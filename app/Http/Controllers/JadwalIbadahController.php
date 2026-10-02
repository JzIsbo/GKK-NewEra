<?php

namespace App\Http\Controllers;

use App\Models\JadwalIbadah;
use Illuminate\Http\Request;

class JadwalIbadahController extends Controller
{
    public function index()
    {
        $jadwals = JadwalIbadah::orderByRaw("
            CASE hari
                WHEN 'Minggu' THEN 1
                WHEN 'Senin' THEN 2
                WHEN 'Selasa' THEN 3
                WHEN 'Rabu' THEN 4
                WHEN 'Kamis' THEN 5
                WHEN 'Jumat' THEN 6
                WHEN 'Sabtu' THEN 7
                ELSE 8
            END
        ")->get();
        return view('majelis.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('majelis.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => ['required', 'string', 'max:255'],
            'hari'           => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'waktu_mulai'    => ['required', 'date_format:H:i'],
            'waktu_selesai'  => ['nullable', 'date_format:H:i'],
            'lokasi'         => ['nullable', 'string', 'max:255'],
            'jenis'          => ['nullable', 'in:reguler,khusus,kategorial'],
            'pelayan_firman' => ['nullable', 'string', 'max:255'],
            'worship_leader' => ['nullable', 'string', 'max:255'],
            'pemusik'        => ['nullable', 'string', 'max:255'],
            'pengajar'       => ['nullable', 'string', 'max:255'],
            'keterangan'     => ['nullable', 'string'],
        ]);

        JadwalIbadah::create(array_merge($request->all(), [
            'aktif' => $request->boolean('aktif'),
        ]));

        return redirect()->route('majelis.jadwal.index')->with('success', 'Jadwal ibadah berhasil ditambahkan.');
    }

    public function edit(JadwalIbadah $jadwal)
    {
        return view('majelis.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, JadwalIbadah $jadwal)
    {
        $request->validate([
            'nama'           => ['required', 'string', 'max:255'],
            'hari'           => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'waktu_mulai'    => ['required', 'date_format:H:i'],
            'waktu_selesai'  => ['nullable', 'date_format:H:i'],
            'lokasi'         => ['nullable', 'string', 'max:255'],
            'jenis'          => ['nullable', 'in:reguler,khusus,kategorial'],
            'pelayan_firman' => ['nullable', 'string', 'max:255'],
            'worship_leader' => ['nullable', 'string', 'max:255'],
            'pemusik'        => ['nullable', 'string', 'max:255'],
            'pengajar'       => ['nullable', 'string', 'max:255'],
            'keterangan'     => ['nullable', 'string'],
        ]);

        $jadwal->update(array_merge($request->all(), [
            'aktif' => $request->boolean('aktif'),
        ]));

        return redirect()->route('majelis.jadwal.index')->with('success', 'Jadwal ibadah berhasil diperbarui.');
    }

    public function destroy(JadwalIbadah $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('majelis.jadwal.index')->with('success', 'Jadwal ibadah berhasil dihapus.');
    }
}
