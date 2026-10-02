<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanApp;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $settingKeys = [
            'nama_gereja', 'alamat_gereja', 'telepon_gereja', 'email_gereja',
            'nama_pendeta', 'rekening_gereja', 'facebook_url', 'instagram_url',
            'youtube_url', 'tentang_gereja',
        ];

        $settings = [];
        foreach ($settingKeys as $key) {
            $settings[$key] = PengaturanApp::get($key);
        }

        return view('admin.pengaturan', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_gereja'     => ['required', 'string', 'max:255'],
            'alamat_gereja'   => ['nullable', 'string'],
            'telepon_gereja'  => ['nullable', 'string', 'max:20'],
            'email_gereja'    => ['nullable', 'email'],
            'nama_pendeta'    => ['nullable', 'string', 'max:255'],
            'rekening_gereja' => ['nullable', 'string'],
            'facebook_url'    => ['nullable', 'url'],
            'instagram_url'   => ['nullable', 'url'],
            'youtube_url'     => ['nullable', 'url'],
            'tentang_gereja'  => ['nullable', 'string'],
        ]);

        $settingKeys = [
            'nama_gereja', 'alamat_gereja', 'telepon_gereja', 'email_gereja',
            'nama_pendeta', 'rekening_gereja', 'facebook_url', 'instagram_url',
            'youtube_url', 'tentang_gereja',
        ];

        foreach ($settingKeys as $key) {
            PengaturanApp::set($key, $request->get($key));
        }

        return redirect()->route('admin.pengaturan')->with('success', 'Pengaturan aplikasi berhasil disimpan.');
    }
}
