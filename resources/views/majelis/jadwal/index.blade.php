@extends('layouts.app')

@section('title', 'Jadwal Ibadah')
@section('header-title', 'Jadwal Ibadah')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">Manajemen Jadwal Ibadah</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Jadwal Ibadah</span>
            </div>
        </div>
        <a href="{{ route('majelis.jadwal.create') }}" class="btn btn-primary">➕ Tambah Jadwal</a>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Daftar Kegiatan Ibadah</div></div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nama Ibadah</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                        <tr>
                            <td class="fw-semibold">
                                <div>{{ $j->nama }}</div>
                                @if($j->keterangan)
                                    <div class="text-muted small fw-normal" style="font-style: italic;">{{ Str::limit($j->keterangan, 60) }}</div>
                                @endif
                                @if($j->pelayan_firman || $j->worship_leader || $j->pemusik || $j->pengajar)
                                    <div style="font-size: 11px; margin-top: 4px; font-weight: normal; color: var(--text-muted);">
                                        @if($j->pelayan_firman) <span>👤 Pelayan Firman : <strong>{{ $j->pelayan_firman }}</strong></span> @endif
                                        @if($j->worship_leader) <span style="margin-left: 8px;">🎤 WL : {{ $j->worship_leader }}</span> @endif
                                        @if($j->pengajar) <span style="margin-left: 8px;">🎓 Pengajar : {{ $j->pengajar }}</span> @endif
                                        @if($j->pemusik) <span style="margin-left: 8px;">🎹 Pemusik : {{ $j->pemusik }}</span> @endif
                                    </div>
                                @endif
                            </td>
                            <td>{{ $j->hari }}</td>
                            <td>{{ substr($j->waktu_mulai, 0, 5) }} {{ $j->waktu_selesai ? '- ' . substr($j->waktu_selesai, 0, 5) : '' }} WIB</td>
                            <td>{{ $j->lokasi ?: 'Gedung Utama' }}</td>
                            <td>
                                @if($j->jenis === 'reguler')
                                    <span class="badge badge-info">Reguler</span>
                                @elseif($j->jenis === 'khusus')
                                    <span class="badge badge-warning">Khusus</span>
                                @else
                                    <span class="badge badge-gold">Kategorial</span>
                                @endif
                            </td>
                            <td>
                                @if($j->aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('majelis.jadwal.edit', $j->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                    
                                    <form method="POST" action="{{ route('majelis.jadwal.destroy', $j->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ibadah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data jadwal ibadah. Silakan tambahkan jadwal baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
