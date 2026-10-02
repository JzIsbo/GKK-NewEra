<?php

namespace App\Http\Controllers;

use App\Enums\AppRole;
use App\Models\JadwalIbadah;
use App\Models\KehadiranIbadah;
use Illuminate\Http\Request;

class KehadiranIbadahController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $kategoriId = $this->getKategoriIdForUser($user);

        $query = KehadiranIbadah::with(['jadwalIbadah.kategori']);

        // Filter by kategorial role
        if ($kategoriId) {
            $query->whereHas('jadwalIbadah', function($q) use ($kategoriId) {
                $q->where('kategori_id', $kategoriId);
            });
        }

        // Search filter
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('jadwalIbadah', function($jq) use ($search) {
                      $jq->where('nama', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%");
                  });
            });
        }

        // Date range filter
        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        // Fetch stats using database aggregation (avoids hydrating all records into memory)
        $stats = (clone $query)->selectRaw('
            COUNT(*) as total_events,
            SUM(COALESCE(jumlah_pria, 0) + COALESCE(jumlah_wanita, 0) + COALESCE(jumlah_anak, 0)) as total_presence
        ')->first();

        $totalEvents = (int) ($stats->total_events ?? 0);
        $totalPresence = (int) ($stats->total_presence ?? 0);
        $avgPresence = $totalEvents > 0 ? (int) round($totalPresence / $totalEvents) : 0;

        $kehadirans = $query->latest('tanggal')->paginate(15)->withQueryString();
        $kategoriNama = $kategoriId ? auth()->user()->kategori?->nama : null;

        return view('kehadiran.index', compact(
            'kehadirans', 'totalEvents', 'totalPresence', 'avgPresence', 'kategoriNama'
        ));
    }

    public function create()
    {
        $user = auth()->user();
        $kategoriId = $this->getKategoriIdForUser($user);

        if ($kategoriId) {
            $jadwals = JadwalIbadah::where('kategori_id', $kategoriId)->where('aktif', true)->orderBy('nama')->get();
        } else {
            $jadwals = JadwalIbadah::where('aktif', true)->orderBy('nama')->get();
        }

        return view('kehadiran.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_ibadah_id' => ['required', 'exists:jadwal_ibadahs,id'],
            'tanggal'          => [
                'required', 'date',
                // Cegah double-entry: satu jadwal hanya boleh satu catatan per tanggal
                \Illuminate\Validation\Rule::unique('kehadiran_ibadahs')
                    ->where('jadwal_ibadah_id', $request->jadwal_ibadah_id),
            ],
            'jumlah_pria'      => ['required', 'integer', 'min:0'],
            'jumlah_wanita'    => ['required', 'integer', 'min:0'],
            'jumlah_anak'      => ['required', 'integer', 'min:0'],
            'keterangan'       => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal.unique' => 'Kehadiran untuk jadwal dan tanggal ini sudah pernah dicatat.',
        ]);

        $user = auth()->user();
        $kategoriId = $this->getKategoriIdForUser($user);

        $jadwal = JadwalIbadah::findOrFail($request->jadwal_ibadah_id);
        
        // Ensure kategorial pengurus can only record for their own category
        if ($kategoriId && $jadwal->kategori_id != $kategoriId) {
            return back()->with('error', 'Anda tidak memiliki hak untuk merekam kehadiran ibadah ini.')->withInput();
        }

        KehadiranIbadah::create([
            'jadwal_ibadah_id' => $request->jadwal_ibadah_id,
            'tanggal'          => $request->tanggal,
            'jumlah_pria'      => $request->jumlah_pria,
            'jumlah_wanita'    => $request->jumlah_wanita,
            'jumlah_anak'      => $request->jumlah_anak,
            'keterangan'       => $request->keterangan,
        ]);

        return redirect()->route('majelis.kehadiran.index')
            ->with('success', 'Data kehadiran ibadah berhasil dicatat.');
    }

    public function edit($id)
    {
        $kehadiran = KehadiranIbadah::with('jadwalIbadah')->findOrFail($id);
        $user = auth()->user();
        $kategoriId = $this->getKategoriIdForUser($user);

        // Access check
        if ($kategoriId && $kehadiran->jadwalIbadah->kategori_id != $kategoriId) {
            abort(403, 'Anda tidak memiliki hak untuk mengakses data ini.');
        }

        if ($kategoriId) {
            $jadwals = JadwalIbadah::where('kategori_id', $kategoriId)->where('aktif', true)->orderBy('nama')->get();
        } else {
            $jadwals = JadwalIbadah::where('aktif', true)->orderBy('nama')->get();
        }

        return view('kehadiran.edit', compact('kehadiran', 'jadwals'));
    }

    public function update(Request $request, $id)
    {
        $kehadiran = KehadiranIbadah::with('jadwalIbadah')->findOrFail($id);
        $user = auth()->user();
        $kategoriId = $this->getKategoriIdForUser($user);

        // Access check
        if ($kategoriId && $kehadiran->jadwalIbadah->kategori_id != $kategoriId) {
            abort(403, 'Anda tidak memiliki hak untuk memodifikasi data ini.');
        }

        $request->validate([
            'jadwal_ibadah_id' => ['required', 'exists:jadwal_ibadahs,id'],
            'tanggal'          => [
                'required', 'date',
                // Ignore record saat ini saat update
                \Illuminate\Validation\Rule::unique('kehadiran_ibadahs')
                    ->where('jadwal_ibadah_id', $request->jadwal_ibadah_id)
                    ->ignore($kehadiran->id),
            ],
            'jumlah_pria'      => ['required', 'integer', 'min:0'],
            'jumlah_wanita'    => ['required', 'integer', 'min:0'],
            'jumlah_anak'      => ['required', 'integer', 'min:0'],
            'keterangan'       => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal.unique' => 'Kehadiran untuk jadwal dan tanggal ini sudah pernah dicatat.',
        ]);

        $jadwal = JadwalIbadah::findOrFail($request->jadwal_ibadah_id);
        
        // Ensure category validation on update as well
        if ($kategoriId && $jadwal->kategori_id != $kategoriId) {
            return back()->with('error', 'Anda tidak memiliki hak untuk merekam kehadiran ibadah ini.')->withInput();
        }

        $kehadiran->update([
            'jadwal_ibadah_id' => $request->jadwal_ibadah_id,
            'tanggal'          => $request->tanggal,
            'jumlah_pria'      => $request->jumlah_pria,
            'jumlah_wanita'    => $request->jumlah_wanita,
            'jumlah_anak'      => $request->jumlah_anak,
            'keterangan'       => $request->keterangan,
        ]);

        return redirect()->route('majelis.kehadiran.index')
            ->with('success', 'Data kehadiran ibadah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kehadiran = KehadiranIbadah::with('jadwalIbadah')->findOrFail($id);
        $user = auth()->user();
        $kategoriId = $this->getKategoriIdForUser($user);

        // Access check
        if ($kategoriId && $kehadiran->jadwalIbadah->kategori_id != $kategoriId) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus data ini.');
        }

        $kehadiran->delete();

        return redirect()->route('majelis.kehadiran.index')
            ->with('success', 'Data kehadiran ibadah berhasil dihapus.');
    }

    /**
     * Kembalikan kategori_id user jika ia adalah pengurus kategorial,
     * null jika majelis / super_admin (akses semua kategori).
     *
     * Menggunakan kolom kategori_id di tabel users — tidak ada DB query tambahan.
     */
    private function getKategoriIdForUser($user): ?int
    {
        $isPengurus = $user->hasAnyRole(AppRole::KATEGORIAL);

        return $isPengurus ? $user->kategori_id : null;
    }
}
