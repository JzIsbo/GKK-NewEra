<?php

namespace App\Http\Controllers;

use App\Models\JadwalIbadah;
use App\Models\Kegiatan;
use App\Models\PendaftaranJemaat;
use App\Models\Pengumuman;
use App\Models\PengaturanApp;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $jadwals      = JadwalIbadah::where('aktif', true)->get();
        $pengumumans  = Pengumuman::aktif()->latest()->take(6)->get();
        $kegiatans    = Kegiatan::where('aktif', true)->where('tanggal_mulai', '>=', now())->orderBy('tanggal_mulai')->take(4)->get();
        $settings     = [
            'nama_gereja'    => PengaturanApp::get('nama_gereja', 'GEMINDO Kawan Kasih'),
            'alamat_gereja'  => PengaturanApp::get('alamat_gereja'),
            'telepon_gereja' => PengaturanApp::get('telepon_gereja'),
            'email_gereja'   => PengaturanApp::get('email_gereja'),
            'nama_pendeta'   => PengaturanApp::get('nama_pendeta'),
            'tentang_gereja' => PengaturanApp::get('tentang_gereja'),
            'facebook_url'   => PengaturanApp::get('facebook_url', '#'),
            'instagram_url'  => PengaturanApp::get('instagram_url', '#'),
            'youtube_url'    => PengaturanApp::get('youtube_url', '#'),
        ];
        return view('public.index', compact('jadwals', 'pengumumans', 'kegiatans', 'settings'));
    }

    public function daftarJemaatForm()
    {
        return view('public.daftar-jemaat');
    }

    public function daftarJemaatStore(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'email'         => [
                'required', 'email',
                // Tidak boleh sudah ada di pendaftaran_jemaats
                \Illuminate\Validation\Rule::unique('pendaftaran_jemaats', 'email'),
                // Tidak boleh sudah ada di users (sudah jadi anggota)
                \Illuminate\Validation\Rule::unique('users', 'email'),
            ],
            'no_telepon'    => ['required', 'string', 'max:20'],
            'alamat'        => ['required', 'string'],
            'jenis_kelamin' => ['nullable', 'in:laki-laki,perempuan'],
            'tanggal_lahir' => ['nullable', 'date'],
            'tempat_lahir'  => ['nullable', 'string', 'max:100'],
            'asal_gereja'   => ['nullable', 'string', 'max:255'],
            'pekerjaan'     => ['nullable', 'string', 'max:100'],
            'alasan_bergabung' => ['nullable', 'string'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email ini sudah terdaftar. Jika Anda sudah menjadi anggota, silakan login.',
            'no_telepon.required'   => 'Nomor telepon wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
        ]);

        // Gunakan only() bukan all() untuk mencegah mass assignment injection
        // (misal: penyerang bisa inject status=disetujui via crafted POST)
        PendaftaranJemaat::create($request->only([
            'nama_lengkap', 'email', 'no_telepon', 'tanggal_lahir',
            'tempat_lahir', 'jenis_kelamin', 'alamat', 'asal_gereja',
            'pekerjaan', 'alasan_bergabung',
        ]));

        return redirect()->route('daftar-jemaat.success');
    }

    public function daftarJemaatSuccess()
    {
        return view('public.daftar-success');
    }
}
