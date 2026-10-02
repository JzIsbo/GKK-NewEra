@extends('layouts.app')

@section('title', 'Kehadiran Ibadah')
@section('header-title', 'Kehadiran Ibadah')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">
                Monitoring Kehadiran Ibadah
                @if($kategoriNama)
                    ➔ {{ $kategoriNama }}
                @endif
            </h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Kehadiran Ibadah</span>
            </div>
        </div>
        @can('manage-kehadiran')
            <a href="{{ route('majelis.kehadiran.create') }}" class="btn btn-primary">➕ Catat Kehadiran</a>
        @endcan
    </div>
</div>

<!-- STAT CARDS -->
<div class="stat-grid" style="margin-bottom: 24px;">
    <!-- Stat 1: Total Ibadah -->
    <div class="stat-card">
        <div class="stat-icon purple">🗓️</div>
        <div>
            <div class="stat-value">{{ $totalEvents }}</div>
            <div class="stat-label">Total Ibadah Dicatat</div>
        </div>
    </div>
    
    <!-- Stat 2: Total Kehadiran -->
    <div class="stat-card">
        <div class="stat-icon green">👥</div>
        <div>
            <div class="stat-value">{{ number_format($totalPresence, 0, ',', '.') }}</div>
            <div class="stat-label">Total Kehadiran Jemaat</div>
        </div>
    </div>
    
    <!-- Stat 3: Rata-Rata Kehadiran -->
    <div class="stat-card">
        <div class="stat-icon gold">📈</div>
        <div>
            <div class="stat-value">{{ number_format($avgPresence, 0, ',', '.') }}</div>
            <div class="stat-label">Rata-rata Kehadiran / Ibadah</div>
        </div>
    </div>
</div>

<!-- FILTER AREA -->
<div class="card mb-3" style="background: var(--card); border: 1px solid var(--border);">
    <div class="card-body" style="padding: 16px 20px;">
        <form method="GET" action="{{ route('majelis.kehadiran.index') }}" class="d-flex gap-2 align-items-center" style="flex-wrap: wrap; width: 100%;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-control" placeholder="Cari ibadah, lokasi, keterangan..." value="{{ request('search') }}">
            </div>
            <div class="d-flex gap-2 align-items-center" style="flex-wrap: wrap;">
                <div>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}" placeholder="Mulai">
                </div>
                <div style="font-size: 13px; color: var(--text-muted);">s/d</div>
                <div>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}" placeholder="Selesai">
                </div>
            </div>
            <button type="submit" class="btn btn-outline" style="padding: 10px 20px;">Filter</button>
            @if(request('search') || request('tanggal_mulai') || request('tanggal_selesai'))
                <a href="{{ route('majelis.kehadiran.index') }}" class="btn btn-outline" style="border-color: transparent;">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- DATA TABLE -->
<div class="card">
    <div class="card-header"><div class="card-title">Log Kehadiran Ibadah</div></div>
    <div class="card-body">
        <div class="table-wrapper table-responsive-stack">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th>Ibadah</th>
                        <th>Tanggal</th>
                        <th style="text-align: center;">Pria</th>
                        <th style="text-align: center;">Wanita</th>
                        <th style="text-align: center;">Anak</th>
                        <th style="text-align: center; font-weight: bold; color: var(--accent-dark);">Total</th>
                        <th>Keterangan</th>
                        @can('manage-kehadiran')
                            <th style="width: 150px;">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadirans as $k)
                        <tr>
                            <td data-label="Ibadah" class="cell-title">
                                <div class="fw-semibold" style="font-size: 14.5px; color: var(--primary);">{{ $k->jadwalIbadah->nama }}</div>
                                <div style="margin-top: 3px;">
                                    @if($k->jadwalIbadah->kategori)
                                        <span class="badge badge-gold" style="font-size: 10px;">{{ $k->jadwalIbadah->kategori->nama }}</span>
                                    @else
                                        <span class="badge badge-info" style="font-size: 10px;">Reguler / Umum</span>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Tanggal">{{ $k->tanggal->translatedFormat('d F Y') }}</td>
                            <td data-label="Pria" style="text-align: center;">{{ $k->jumlah_pria }}</td>
                            <td data-label="Wanita" style="text-align: center;">{{ $k->jumlah_wanita }}</td>
                            <td data-label="Anak" style="text-align: center;">{{ $k->jumlah_anak }}</td>
                            <td data-label="Total" style="text-align: center;" class="fw-bold text-success">{{ $k->total_kehadiran }}</td>
                            <td data-label="Keterangan" class="text-muted small">
                                {{ $k->keterangan ?: '-' }}
                            </td>
                            @can('manage-kehadiran')
                                <td data-label="Aksi">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('majelis.kehadiran.edit', $k->id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                                        <form method="POST" action="{{ route('majelis.kehadiran.destroy', $k->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kehadiran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->can('manage-kehadiran') ? 8 : 7 }}" class="text-center text-muted" style="padding: 24px;">Belum ada catatan kehadiran ibadah yang sesuai pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kehadirans->hasPages())
            <div class="pagination-wrapper">
                {{ $kehadirans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
