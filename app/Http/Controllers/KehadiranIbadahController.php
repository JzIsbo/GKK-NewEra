<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
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

        // Fetch stats before pagination
        $statsQuery = clone $query;
        $allKehadirans = $statsQuery->get();
        
        $totalEvents = $allKehadirans->count();
        $totalPresence = $allKehadirans->sum(function($item) {
            return $item->total_kehadiran;
        });
        $avgPresence = $totalEvents > 0 ? round($totalPresence / $totalEvents) : 0;

        $kehadirans = $query->latest('tanggal')->paginate(15)->withQueryString();
        $kategoriNama = $kategoriId ? Kategori::find($kategoriId)?->nama : null;

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
            'tanggal'          => ['required', 'date'],
            'jumlah_pria'      => ['required', 'integer', 'min:0'],
            'jumlah_wanita'    => ['required', 'integer', 'min:0'],
            'jumlah_anak'      => ['required', 'integer', 'min:0'],
            'keterangan'       => ['nullable', 'string', 'max:500'],
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
            'tanggal'          => ['required', 'date'],
            'jumlah_pria'      => ['required', 'integer', 'min:0'],
            'jumlah_wanita'    => ['required', 'integer', 'min:0'],
            'jumlah_anak'      => ['required', 'integer', 'min:0'],
            'keterangan'       => ['nullable', 'string', 'max:500'],
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

    private function getKategoriIdForUser($user)
    {
        if ($user->hasRole('pengurus_kategorial_kpb')) {
            return Kategori::where('nama', 'Pria/Bapak')->value('id');
        }
        if ($user->hasRole('pengurus_kategorial_kpw')) {
            return Kategori::where('nama', 'Perempuan')->value('id');
        }
        if ($user->hasRole('pengurus_kategorial_kpp')) {
            return Kategori::where('nama', 'Pemuda')->value('id');
        }
        if ($user->hasRole('pengurus_kategorial_kpr')) {
            return Kategori::where('nama', 'Remaja')->value('id');
        }
        if ($user->hasRole('pengurus_kategorial_kpa')) {
            return Kategori::where('nama', 'Anak')->value('id');
        }
        return null;
    }
}
