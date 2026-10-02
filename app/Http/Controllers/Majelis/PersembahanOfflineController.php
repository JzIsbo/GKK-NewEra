<?php

namespace App\Http\Controllers\Majelis;

use App\Http\Controllers\Controller;
use App\Models\JenisPersembahan;
use App\Models\Persembahan;
use App\Models\User;
use Illuminate\Http\Request;

class PersembahanOfflineController extends Controller
{
    public function index(Request $request)
    {
        $query = Persembahan::with('jenisPersembahan', 'user')
            ->where(function($q) {
                $q->whereNull('snap_token')
                  ->orWhereIn('metode_bayar', ['Tunai', 'Transfer Manual', 'Offline']);
            });

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_donatur', 'like', "%{$request->search}%")
                  ->orWhere('keterangan', 'like', "%{$request->search}%")
                  ->orWhereHas('jenisPersembahan', function($jq) use ($request) {
                      $jq->where('nama', 'like', "%{$request->search}%");
                  });
            });
        }

        $persembahans = $query->latest('paid_at')->paginate(15)->withQueryString();

        return view('majelis.persembahan-offline.index', compact('persembahans'));
    }

    public function create()
    {
        $jenisPersembahans = JenisPersembahan::where('aktif', true)->orderBy('nama')->get();
        $jemaats = User::role('jemaat')->orderBy('nama_lengkap')->orderBy('name')->get();
        return view('majelis.persembahan-offline.create', compact('jenisPersembahans', 'jemaats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_persembahan_id' => ['required', 'exists:jenis_persembahans,id'],
            'nominal'              => ['required', 'numeric', 'min:1000'],
            'tipe_donatur'         => ['required', 'in:jemaat,non-jemaat'],
            'user_id'              => ['required_if:tipe_donatur,jemaat', 'nullable', 'exists:users,id'],
            'nama_donatur'         => ['required_if:tipe_donatur,non-jemaat', 'nullable', 'string', 'max:255'],
            'metode_bayar'         => ['required', 'in:Tunai,Transfer Manual'],
            'paid_at'              => ['required', 'date'],
            'keterangan'           => ['nullable', 'string', 'max:500'],
        ]);

        $userId = null;
        $namaDonatur = $request->nama_donatur;

        if ($request->tipe_donatur === 'jemaat') {
            $userId = $request->user_id;
            $user = User::findOrFail($userId);
            $namaDonatur = $user->nama_lengkap ?: $user->name;
        }

        Persembahan::create([
            'order_id'             => 'GKK-OFFLINE-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'user_id'              => $userId,
            'nama_donatur'         => $namaDonatur,
            'jenis_persembahan_id' => $request->jenis_persembahan_id,
            'nominal'              => $request->nominal,
            'metode_bayar'         => $request->metode_bayar,
            'status'               => 'success',
            'paid_at'              => $request->paid_at,
            'keterangan'           => $request->keterangan,
        ]);

        return redirect()->route('majelis.persembahan-offline.index')
            ->with('success', 'Persembahan offline berhasil dicatat.');
    }

    public function edit($id)
    {
        $persembahan = Persembahan::findOrFail($id);
        $jenisPersembahans = JenisPersembahan::where('aktif', true)->orderBy('nama')->get();
        $jemaats = User::role('jemaat')->orderBy('nama_lengkap')->orderBy('name')->get();
        return view('majelis.persembahan-offline.edit', compact('persembahan', 'jenisPersembahans', 'jemaats'));
    }

    public function update(Request $request, $id)
    {
        $persembahan = Persembahan::findOrFail($id);

        $request->validate([
            'jenis_persembahan_id' => ['required', 'exists:jenis_persembahans,id'],
            'nominal'              => ['required', 'numeric', 'min:1000'],
            'tipe_donatur'         => ['required', 'in:jemaat,non-jemaat'],
            'user_id'              => ['required_if:tipe_donatur,jemaat', 'nullable', 'exists:users,id'],
            'nama_donatur'         => ['required_if:tipe_donatur,non-jemaat', 'nullable', 'string', 'max:255'],
            'metode_bayar'         => ['required', 'in:Tunai,Transfer Manual'],
            'paid_at'              => ['required', 'date'],
            'keterangan'           => ['nullable', 'string', 'max:500'],
        ]);

        $userId = null;
        $namaDonatur = $request->nama_donatur;

        if ($request->tipe_donatur === 'jemaat') {
            $userId = $request->user_id;
            $user = User::findOrFail($userId);
            $namaDonatur = $user->nama_lengkap ?: $user->name;
        }

        $persembahan->update([
            'user_id'              => $userId,
            'nama_donatur'         => $namaDonatur,
            'jenis_persembahan_id' => $request->jenis_persembahan_id,
            'nominal'              => $request->nominal,
            'metode_bayar'         => $request->metode_bayar,
            'paid_at'              => $request->paid_at,
            'keterangan'           => $request->keterangan,
        ]);

        return redirect()->route('majelis.persembahan-offline.index')
            ->with('success', 'Catatan persembahan offline berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $persembahan = Persembahan::findOrFail($id);
        $persembahan->delete();

        return redirect()->route('majelis.persembahan-offline.index')
            ->with('success', 'Catatan persembahan offline berhasil dihapus.');
    }
}
