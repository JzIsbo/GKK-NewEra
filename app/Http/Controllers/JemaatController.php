<?php

namespace App\Http\Controllers;

use App\Models\PengaturanApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class JemaatController extends Controller
{
    public function profil()
    {
        $user = Auth::user()->load('kategori');
        $kategoris = \App\Models\Kategori::where('aktif', true)->get();
        return view('jemaat.profil', compact('user', 'kategoris'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nama_lengkap'      => ['required', 'string', 'max:255'],
            'no_telepon'        => ['nullable', 'string', 'max:20'],
            'alamat'            => ['nullable', 'string'],
            'tanggal_lahir'     => ['nullable', 'date'],
            'tempat_lahir'      => ['nullable', 'string', 'max:100'],
            'jenis_kelamin'     => ['nullable', 'in:laki-laki,perempuan'],
            'pekerjaan'         => ['nullable', 'string', 'max:100'],
            'status_pernikahan' => ['nullable', 'in:belum_menikah,menikah,janda,duda'],
            'foto'              => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except('foto', '_token', '_method');

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-jemaat', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function kartuJemaat()
    {
        $user = Auth::user();

        // Generate QR Code via public API (no local library needed)
        $qrData   = $user->nomor_jemaat ?: $user->email;
        $qrUrl    = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrData);
        $qrBase64 = null;

        try {
            $ctx = stream_context_create(['http' => ['timeout' => 2]]);
            $qrImageData = @file_get_contents($qrUrl, false, $ctx);
            if ($qrImageData !== false) {
                $qrBase64 = base64_encode($qrImageData);
            }
        } catch (\Throwable $e) {
            // fallback: QR tidak merusak download PDF
        }

        $settings = [
            'nama_gereja'   => PengaturanApp::get('nama_gereja', 'GEMINDO Kawan Kasih'),
            'alamat_gereja' => PengaturanApp::get('alamat_gereja', ''),
        ];

        $pdf = Pdf::loadView('jemaat.kartu-jemaat-pdf', compact('user', 'qrBase64', 'settings'));
        $pdf->setPaper([0, 0, 255, 155]);

        return $pdf->download('kartu-jemaat-' . ($user->nomor_jemaat ?: $user->id) . '.pdf');
    }
}
