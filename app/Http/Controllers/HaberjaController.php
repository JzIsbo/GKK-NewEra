<?php

namespace App\Http\Controllers;

use App\Enums\AppRole;
use App\Models\HaberjaEvent;
use App\Models\HaberjaPanitia;
use App\Models\HaberjaDanaPlan;
use App\Models\HaberjaBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HaberjaController extends Controller
{
    /**
     * Check if authenticated user has permission to manage HABERJA data.
     */
    protected function canManage(): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        return $user->hasAnyRole([
            AppRole::SUPER_ADMIN,
            AppRole::MAJELIS,
            AppRole::SEKRETARIS_MAJELIS,
            AppRole::BENDAHARA_MAJELIS,
            ...AppRole::KATEGORIAL,
        ]);
    }

    /**
     * Display the main HABERJA dashboard, committee structure, fundraising, and budgeting.
     */
    public function index(Request $request)
    {
        $events = HaberjaEvent::orderBy('tanggal_mulai')->get();
        $selectedKode = $request->query('event', 'semua');
        $activeTab = $request->query('tab', 'overview');

        $currentEvent = null;
        if ($selectedKode !== 'semua') {
            $currentEvent = $events->firstWhere('kode', $selectedKode);
        }

        // 1. Panitia query
        $panitiaQuery = HaberjaPanitia::with('event')->orderBy('urutan');
        if ($currentEvent) {
            $panitiaQuery->where(function ($q) use ($currentEvent) {
                $q->where('event_id', $currentEvent->id)
                  ->orWhereNull('event_id');
            });
        }
        $panitias = $panitiaQuery->get();
        $panitiaBySeksi = $panitias->groupBy('seksi');

        // 2. Dana Plans query
        $danaQuery = HaberjaDanaPlan::with('event')->latest();
        if ($currentEvent) {
            $danaQuery->where(function ($q) use ($currentEvent) {
                $q->where('event_id', $currentEvent->id)
                  ->orWhereNull('event_id');
            });
        }
        $danaPlans = $danaQuery->get();

        // 3. Budgets query
        $budgetQuery = HaberjaBudget::with('event');
        if ($currentEvent) {
            $budgetQuery->where('event_id', $currentEvent->id);
        }
        $budgets = $budgetQuery->get();

        $pengeluarans = $budgets->where('tipe', 'pengeluaran');
        $pemasukans = $budgets->where('tipe', 'pemasukan');

        // Financial Metrics
        $totalTargetRAB = $pengeluarans->sum('total_anggaran');
        $totalRealisasiPengeluaran = $pengeluarans->sum('realisasi');

        $totalRencanaPemasukan = $pemasukans->sum('total_anggaran');
        $totalRealisasiPemasukan = $pemasukans->sum('realisasi');

        $totalTargetDana = $danaPlans->sum('target_dana');
        $totalRealisasiDana = $danaPlans->sum('realisasi_dana');
        $sisaTargetDana = max(0, $totalTargetDana - $totalRealisasiDana);

        $persenDana = $totalTargetDana > 0 
            ? min(100, round(($totalRealisasiDana / $totalTargetDana) * 100, 1)) 
            : 0;

        $persenRABTerpenuhi = $totalTargetRAB > 0 
            ? min(100, round(($totalRealisasiPemasukan / $totalTargetRAB) * 100, 1)) 
            : 0;

        $canManage = $this->canManage();

        return view('haberja.index', compact(
            'events',
            'selectedKode',
            'currentEvent',
            'activeTab',
            'panitias',
            'panitiaBySeksi',
            'danaPlans',
            'pengeluarans',
            'pemasukans',
            'totalTargetRAB',
            'totalRealisasiPengeluaran',
            'totalRencanaPemasukan',
            'totalRealisasiPemasukan',
            'totalTargetDana',
            'totalRealisasiDana',
            'sisaTargetDana',
            'persenDana',
            'persenRABTerpenuhi',
            'canManage'
        ));
    }

    /**
     * Store new committee member.
     */
    public function storePanitia(Request $request)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'event_id'    => 'nullable|exists:haberja_events,id',
            'nama'        => 'required|string|max:255',
            'jabatan'     => 'required|string|max:255',
            'seksi'       => 'required|string|max:100',
            'telepon'     => 'nullable|string|max:50',
            'tugas_pokok' => 'nullable|string',
            'urutan'      => 'nullable|integer',
        ]);

        HaberjaPanitia::create($validated);

        return redirect()->route('haberja.index', ['tab' => 'struktur'])
            ->with('success', 'Anggota panitia HABERJA berhasil ditambahkan.');
    }

    /**
     * Update committee member.
     */
    public function updatePanitia(Request $request, HaberjaPanitia $panitia)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'event_id'    => 'nullable|exists:haberja_events,id',
            'nama'        => 'required|string|max:255',
            'jabatan'     => 'required|string|max:255',
            'seksi'       => 'required|string|max:100',
            'telepon'     => 'nullable|string|max:50',
            'tugas_pokok' => 'nullable|string',
            'urutan'      => 'nullable|integer',
        ]);

        $panitia->update($validated);

        return redirect()->route('haberja.index', ['tab' => 'struktur'])
            ->with('success', 'Data panitia berhasil diperbarui.');
    }

    /**
     * Delete committee member.
     */
    public function destroyPanitia(HaberjaPanitia $panitia)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $panitia->delete();

        return redirect()->route('haberja.index', ['tab' => 'struktur'])
            ->with('success', 'Data panitia telah dihapus.');
    }

    /**
     * Store new fundraising plan.
     */
    public function storeDanaPlan(Request $request)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'event_id'         => 'nullable|exists:haberja_events,id',
            'nama_program'     => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'target_dana'      => 'required|numeric|min:0',
            'realisasi_dana'   => 'nullable|numeric|min:0',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'penanggung_jawab' => 'nullable|string|max:255',
            'status'           => 'required|string|in:rencana,berjalan,tercapai,selesai',
            'catatan'          => 'nullable|string',
        ]);

        $validated['realisasi_dana'] = $validated['realisasi_dana'] ?? 0;

        HaberjaDanaPlan::create($validated);

        return redirect()->route('haberja.index', ['tab' => 'dana'])
            ->with('success', 'Program pencarian dana berhasil ditambahkan.');
    }

    /**
     * Update fundraising plan.
     */
    public function updateDanaPlan(Request $request, HaberjaDanaPlan $danaPlan)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'event_id'         => 'nullable|exists:haberja_events,id',
            'nama_program'     => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'target_dana'      => 'required|numeric|min:0',
            'realisasi_dana'   => 'nullable|numeric|min:0',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_selesai'  => 'nullable|date',
            'penanggung_jawab' => 'nullable|string|max:255',
            'status'           => 'required|string|in:rencana,berjalan,tercapai,selesai',
            'catatan'          => 'nullable|string',
        ]);

        $validated['realisasi_dana'] = $validated['realisasi_dana'] ?? 0;

        $danaPlan->update($validated);

        return redirect()->route('haberja.index', ['tab' => 'dana'])
            ->with('success', 'Data program pencarian dana berhasil diperbarui.');
    }

    /**
     * Delete fundraising plan.
     */
    public function destroyDanaPlan(HaberjaDanaPlan $danaPlan)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $danaPlan->delete();

        return redirect()->route('haberja.index', ['tab' => 'dana'])
            ->with('success', 'Program pencarian dana telah dihapus.');
    }

    /**
     * Store new budget item (RAB).
     */
    public function storeBudget(Request $request)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'event_id'       => 'required|exists:haberja_events,id',
            'tipe'           => 'required|in:pengeluaran,pemasukan',
            'seksi'          => 'required|string|max:100',
            'uraian'         => 'required|string|max:255',
            'volume'         => 'nullable|string|max:100',
            'harga_satuan'   => 'nullable|numeric|min:0',
            'total_anggaran' => 'required|numeric|min:0',
            'realisasi'      => 'nullable|numeric|min:0',
            'keterangan'     => 'nullable|string',
        ]);

        $validated['harga_satuan'] = $validated['harga_satuan'] ?? 0;
        $validated['realisasi'] = $validated['realisasi'] ?? 0;

        HaberjaBudget::create($validated);

        return redirect()->route('haberja.index', ['tab' => 'budget'])
            ->with('success', 'Item anggaran RAB berhasil ditambahkan.');
    }

    /**
     * Update budget item (RAB).
     */
    public function updateBudget(Request $request, HaberjaBudget $budget)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'event_id'       => 'required|exists:haberja_events,id',
            'tipe'           => 'required|in:pengeluaran,pemasukan',
            'seksi'          => 'required|string|max:100',
            'uraian'         => 'required|string|max:255',
            'volume'         => 'nullable|string|max:100',
            'harga_satuan'   => 'nullable|numeric|min:0',
            'total_anggaran' => 'required|numeric|min:0',
            'realisasi'      => 'nullable|numeric|min:0',
            'keterangan'     => 'nullable|string',
        ]);

        $validated['harga_satuan'] = $validated['harga_satuan'] ?? 0;
        $validated['realisasi'] = $validated['realisasi'] ?? 0;

        $budget->update($validated);

        return redirect()->route('haberja.index', ['tab' => 'budget'])
            ->with('success', 'Item anggaran RAB berhasil diperbarui.');
    }

    /**
     * Delete budget item.
     */
    public function destroyBudget(HaberjaBudget $budget)
    {
        abort_unless($this->canManage(), 403, 'Akses ditolak.');

        $budget->delete();

        return redirect()->route('haberja.index', ['tab' => 'budget'])
            ->with('success', 'Item anggaran RAB telah dihapus.');
    }

    /**
     * Printable view of HABERJA report & RAB.
     */
    public function print(Request $request)
    {
        $events = HaberjaEvent::orderBy('tanggal_mulai')->get();
        $selectedKode = $request->query('event', 'semua');

        $currentEvent = null;
        if ($selectedKode !== 'semua') {
            $currentEvent = $events->firstWhere('kode', $selectedKode);
        }

        $panitiaQuery = HaberjaPanitia::orderBy('urutan');
        if ($currentEvent) {
            $panitiaQuery->where(function ($q) use ($currentEvent) {
                $q->where('event_id', $currentEvent->id)
                  ->orWhereNull('event_id');
            });
        }
        $panitias = $panitiaQuery->get();

        $danaQuery = HaberjaDanaPlan::latest();
        if ($currentEvent) {
            $danaQuery->where(function ($q) use ($currentEvent) {
                $q->where('event_id', $currentEvent->id)
                  ->orWhereNull('event_id');
            });
        }
        $danaPlans = $danaQuery->get();

        $budgetQuery = HaberjaBudget::with('event');
        if ($currentEvent) {
            $budgetQuery->where('event_id', $currentEvent->id);
        }
        $budgets = $budgetQuery->get();

        $pengeluarans = $budgets->where('tipe', 'pengeluaran');
        $pemasukans = $budgets->where('tipe', 'pemasukan');

        return view('haberja.print', compact(
            'events',
            'currentEvent',
            'panitias',
            'danaPlans',
            'pengeluarans',
            'pemasukans'
        ));
    }
}
