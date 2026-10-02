@extends('layouts.app')

@section('title', 'Warta Jemaat & Pengumuman')
@section('header-title', 'Warta Jemaat')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div>
        <h1 class="page-header-title">Warta Jemaat &amp; Pengumuman</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pelayanan Majelis</span> &gt; <span>Warta Jemaat</span>
        </div>
    </div>
    <div class="d-flex gap-2" style="flex-wrap: wrap;">
        <a href="{{ url('/#pengumuman') }}" target="_blank" class="btn btn-outline btn-sm">
            🌐 Lihat di Halaman Publik
        </a>
        <a href="{{ route('majelis.pengumuman.create') }}" class="btn btn-primary btn-sm">
            ➕ Tulis Warta Baru
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card mb-3" style="background: linear-gradient(135deg, rgba(200,148,26,.08), rgba(44,24,16,.03)); border: 1px dashed var(--accent);">
    <div class="card-body" style="padding: 14px 18px;">
        <div class="d-flex align-items-center gap-3">
            <div style="font-size: 26px;">📢</div>
            <div>
                <div class="fw-bold" style="color: var(--primary); font-size: 13.5px;">Publikasi Terhubung ke Halaman Utama</div>
                <div class="text-muted small" style="font-size: 12px;">
                    Setiap warta dengan status <strong>"Aktif"</strong> akan secara otomatis ditampilkan di bagian <strong>Warta Jemaat</strong> pada halaman depan (publik) website gereja sehingga dapat diakses oleh seluruh jemaat dan simpatisan.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center gap-2">
            <div class="card-title">Daftar Warta Jemaat</div>
            <span class="badge badge-secondary">{{ $pengumumans->count() }} Warta</span>
        </div>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Judul &amp; Ringkasan Warta</th>
                        <th>Kategori</th>
                        <th>Periode Tayang</th>
                        <th>Status Publik</th>
                        <th>Penulis</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumans as $p)
                        <tr>
                            <td data-label="Judul" class="cell-title">
                                <div class="fw-bold" style="font-size: 14.5px; color: var(--primary);">
                                    {{ $p->judul }}
                                </div>
                                <div class="text-muted small" style="margin-top: 3px; line-height: 1.4;">
                                    {{ Str::limit($p->isi, 90) }}
                                </div>
                            </td>
                            <td data-label="Kategori">
                                @if($p->tipe === 'penting')
                                    <span class="badge badge-danger">Penting</span>
                                @elseif($p->tipe === 'kegiatan')
                                    <span class="badge badge-info">Kegiatan</span>
                                @else
                                    <span class="badge badge-secondary">Umum</span>
                                @endif
                            </td>
                            <td data-label="Periode">
                                <div class="small fw-semibold">
                                    {{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}
                                </div>
                                <div class="text-muted" style="font-size: 11px;">
                                    s.d. {{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : 'Seterusnya' }}
                                </div>
                            </td>
                            <td data-label="Status">
                                @if($p->aktif)
                                    <span class="badge badge-success">✓ Tayang di Web</span>
                                @else
                                    <span class="badge badge-secondary">Draft / Nonaktif</span>
                                @endif
                            </td>
                            <td data-label="Penulis">
                                <span class="small text-muted">{{ $p->penulis->name ?? 'Majelis / Admin' }}</span>
                            </td>
                            <td data-label="Aksi" style="text-align: center;">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('majelis.pengumuman.edit', $p->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                    
                                    <form method="POST" action="{{ route('majelis.pengumuman.destroy', $p->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus warta jemaat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding: 40px;">
                                Belum ada warta jemaat yang diterbitkan. Silakan klik tombol <strong>"➕ Tulis Warta Baru"</strong> untuk mempublikasikan warta ke website gereja.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
