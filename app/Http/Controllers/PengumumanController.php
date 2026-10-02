<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->get();
        return view('majelis.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('majelis.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'isi'             => ['required', 'string'],
            'tipe'            => ['nullable', 'in:umum,penting,kegiatan'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        Pengumuman::create(array_merge($request->all(), [
            'tipe'     => $request->input('tipe', 'umum'),
            'aktif'    => $request->boolean('aktif'),
            'user_id'  => Auth::id(),
        ]));

        return redirect()->route('majelis.pengumuman.index')->with('success', 'Warta jemaat berhasil ditambahkan dan siap tampil di website publik.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('majelis.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'isi'             => ['required', 'string'],
            'tipe'            => ['nullable', 'in:umum,penting,kegiatan'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $pengumuman->update(array_merge($request->all(), [
            'tipe'  => $request->input('tipe', 'umum'),
            'aktif' => $request->boolean('aktif'),
        ]));

        return redirect()->route('majelis.pengumuman.index')->with('success', 'Warta jemaat berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('majelis.pengumuman.index')->with('success', 'Warta jemaat berhasil dihapus.');
    }
}
