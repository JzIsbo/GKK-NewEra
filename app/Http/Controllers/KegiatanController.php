<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Scope queries by category for category coordinators
        if ($user->hasRole('pengurus_kategorial')) {
            if (!$user->kategori_id) {
                return redirect()->route('dashboard')->with('error', 'Akun Pengurus Kategorial Anda belum dikaitkan dengan kategori KPK apa pun. Silakan hubungi Majelis.');
            }
            $kegiatans = Kegiatan::where('kategori_id', $user->kategori_id)
                ->with('kategori', 'penulis')
                ->latest()
                ->paginate(15);
        } else {
            // Admin and Majelis can see and manage all activities
            $kegiatans = Kegiatan::with('kategori', 'penulis')
                ->latest()
                ->paginate(15);
        }

        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        $user = Auth::user();
        $kategoris = [];

        if ($user->hasRole('pengurus_kategorial')) {
            if (!$user->kategori_id) {
                return redirect()->route('dashboard')->with('error', 'Akun Pengurus Kategorial Anda belum dikaitkan dengan kategori KPK apa pun.');
            }
        } else {
            $kategoris = Kategori::where('aktif', true)->get();
        }

        return view('kegiatan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama'            => ['required', 'string', 'max:255'],
            'deskripsi'       => ['nullable', 'string'],
            'lokasi'          => ['nullable', 'string', 'max:255'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'gambar'          => ['nullable', 'image', 'max:2048'],
        ];

        // Only allow admin and majelis to choose categories
        if (!$user->hasRole('pengurus_kategorial')) {
            $rules['kategori_id'] = ['nullable', 'exists:kategoris,id'];
        }

        $validated = $request->validate($rules, [
            'nama.required' => 'Nama kegiatan wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai kegiatan wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'gambar.max' => 'Ukuran gambar tidak boleh melebihi 2MB.',
        ]);

        $data = $request->except('gambar');
        $data['user_id'] = $user->id;
        $data['aktif']   = $request->has('aktif') ? true : false;

        // Auto-assign category for category coordinators
        if ($user->hasRole('pengurus_kategorial')) {
            $data['kategori_id'] = $user->kategori_id;
        }

        // Handle Image Upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        Kegiatan::create($data);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $user = Auth::user();

        // Enforce category scope check
        if ($user->hasRole('pengurus_kategorial') && $kegiatan->kategori_id !== $user->kategori_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola kegiatan kategori ini.');
        }

        $kategoris = [];
        if (!$user->hasRole('pengurus_kategorial')) {
            $kategoris = Kategori::where('aktif', true)->get();
        }

        return view('kegiatan.edit', compact('kegiatan', 'kategoris'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $user = Auth::user();

        // Enforce category scope check
        if ($user->hasRole('pengurus_kategorial') && $kegiatan->kategori_id !== $user->kategori_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola kegiatan kategori ini.');
        }

        $rules = [
            'nama'            => ['required', 'string', 'max:255'],
            'deskripsi'       => ['nullable', 'string'],
            'lokasi'          => ['nullable', 'string', 'max:255'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'gambar'          => ['nullable', 'image', 'max:2048'],
        ];

        if (!$user->hasRole('pengurus_kategorial')) {
            $rules['kategori_id'] = ['nullable', 'exists:kategoris,id'];
        }

        $request->validate($rules, [
            'nama.required' => 'Nama kegiatan wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai kegiatan wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'gambar.max' => 'Ukuran gambar tidak boleh melebihi 2MB.',
        ]);

        $data = $request->except('gambar');
        $data['aktif'] = $request->has('aktif') ? true : false;

        // Force user's category for category coordinators
        if ($user->hasRole('pengurus_kategorial')) {
            $data['kategori_id'] = $user->kategori_id;
        }

        // Handle Image Update
        if ($request->hasFile('gambar')) {
            if ($kegiatan->gambar) {
                Storage::disk('public')->delete($kegiatan->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        $kegiatan->update($data);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $user = Auth::user();

        // Enforce category scope check
        if ($user->hasRole('pengurus_kategorial') && $kegiatan->kategori_id !== $user->kategori_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola kegiatan kategori ini.');
        }

        // Delete associated image
        if ($kegiatan->gambar) {
            Storage::disk('public')->delete($kegiatan->gambar);
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
