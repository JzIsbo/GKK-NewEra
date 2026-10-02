@extends('layouts.app')

@section('title', 'Manajemen Kegiatan')
@section('header-title', 'Kegiatan')

@section('styles')
<style>
@media (max-width: 480px) {
    .d-flex.justify-content-between { flex-direction: column; align-items: flex-start !important; gap: 12px; }
    .d-flex.justify-content-between .btn { align-self: stretch; text-align: center; }
}
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">Manajemen Kegiatan Gereja</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Kegiatan</span>
            </div>
        </div>
        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">➕ Tambah Kegiatan</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Kegiatan Mendatang & Terlaksana</div>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Kategori / KPK</th>
                        <th>Waktu Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Penulis</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $k)
                        <tr>
                            <td data-label="Nama Kegiatan" class="fw-semibold cell-title">
                                <div class="d-flex align-items-center gap-3">
                                    @if($k->gambar)
                                        <img src="{{ asset('storage/' . $k->gambar) }}" alt="{{ $k->nama }}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border); flex-shrink: 0;">
                                    @else
                                        <div style="width: 44px; height: 44px; background-color: var(--cream); border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); font-size: 18px; flex-shrink: 0;">🕊️</div>
                                    @endif
                                    <div>
                                        <div style="font-size: 15px;">{{ $k->nama }}</div>
                                        <div class="text-muted small fw-normal">{{ Str::limit($k->deskripsi, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Kategori / KPK">
                                @if($k->kategori)
                                    <span style="font-weight: 600; color: var(--burgundy);">{{ $k->kategori->singkatan }}</span>
                                @else
                                    <span class="text-muted">Umum / Semua</span>
                                @endif
                            </td>
                            <td data-label="Waktu Kegiatan">
                                <div style="font-size: 13px; font-weight: 500;">
                                    📅 {{ $k->tanggal_mulai->format('d/m/Y') }}
                                </div>
                                <div class="text-muted small">
                                    🕐 {{ $k->tanggal_mulai->format('H:i') }} WIB
                                    @if($k->tanggal_selesai)
                                        - {{ $k->tanggal_selesai->format('H:i') }} WIB
                                    @endif
                                </div>
                            </td>
                            <td data-label="Lokasi">{{ $k->lokasi ?: '-' }}</td>
                            <td data-label="Status">
                                @if($k->aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td data-label="Penulis">{{ $k->penulis->nama_display ?? 'Staf / Majelis' }}</td>
                            <td data-label="Aksi">
                                <div class="table-actions">
                                    <a href="{{ route('kegiatan.edit', $k->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                    
                                    <form method="POST" action="{{ route('kegiatan.destroy', $k->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 40px;">Belum ada kegiatan yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kegiatans->hasPages())
            <div style="margin-top: 20px;">
                {{ $kegiatans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
