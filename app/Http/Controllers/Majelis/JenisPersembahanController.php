<?php

namespace App\Http\Controllers\Majelis;

use App\Http\Controllers\Controller;
use App\Models\JenisPersembahan;
use Illuminate\Http\Request;

class JenisPersembahanController extends Controller
{
    public function index()
    {
        $kategori = JenisPersembahan::latest()->paginate(10);
        return view('majelis.jenis-persembahan.index', compact('kategori'));
    }

    public function create()
    {
        return view('majelis.jenis-persembahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:jenis_persembahans,nama'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'aktif' => ['boolean'],
        ]);

        JenisPersembahan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->has('aktif') ? (bool) $request->aktif : true,
        ]);

        return redirect()->route('majelis.jenis-persembahan.index')
            ->with('success', 'Kategori persembahan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = JenisPersembahan::findOrFail($id);
        return view('majelis.jenis-persembahan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = JenisPersembahan::findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:jenis_persembahans,nama,' . $id],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'aktif' => ['boolean'],
        ]);

        $item->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->has('aktif') ? (bool) $request->aktif : true,
        ]);

        return redirect()->route('majelis.jenis-persembahan.index')
            ->with('success', 'Kategori persembahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = JenisPersembahan::findOrFail($id);

        // Check if there are offerings associated with this category
        if ($item->persembahans()->count() > 0) {
            // Soft deactivate instead of delete to keep financial records intact
            $item->update(['aktif' => false]);
            return redirect()->route('majelis.jenis-persembahan.index')
                ->with('info', 'Kategori tidak dapat dihapus karena memiliki riwayat transaksi. Kategori telah dinonaktifkan sebagai gantinya.');
        }

        $item->delete();

        return redirect()->route('majelis.jenis-persembahan.index')
            ->with('success', 'Kategori persembahan berhasil dihapus.');
    }
}
