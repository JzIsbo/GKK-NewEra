@extends('layouts.app')

@section('title', 'Dashboard Majelis')
@section('header-title', 'Dashboard Majelis')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div>
        <h1 class="page-header-title" style="margin-bottom: 4px;">Shalom, Majelis Jemaat</h1>
        <div class="breadcrumb">
            <span>Pelayanan Majelis &bull; {{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
    <div class="d-flex gap-2" style="flex-wrap: wrap;">
        <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-accent btn-sm">
            📰 Kelola Warta Jemaat
        </a>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline btn-sm">
            🌐 Halaman Publik
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div>
            <div class="stat-value">{{ number_format($totalJemaat) }}</div>
            <div class="stat-label">Total Jemaat</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange warning">⌛</div>
        <div>
            <div class="stat-value">{{ number_format($pendingPendaftaran) }}</div>
            <div class="stat-label">
                Pendaftaran Menunggu
                @if($pendingPendaftaran > 0)
                    <span class="badge badge-warning" style="font-size: 10px; margin-left: 4px;">Perlu Validasi</span>
                @endif
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">Rp</div>
        <div>
            <div class="stat-value">{{ number_format($totalPersembahan, 0, ',', '.') }}</div>
            <div class="stat-label">Persembahan Bulan Ini</div>
        </div>
    </div>
</div>

<!-- Main Grid -->
<div class="dashboard-grid">
    <!-- Recent Offerings -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2">
                <div class="card-title">Persembahan Masuk Terbaru</div>
                <span class="badge badge-secondary">{{ count($recentPersembahan) }}</span>
            </div>
            <a href="{{ route('majelis.laporan') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Donatur &amp; Waktu</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPersembahan as $p)
                            <tr>
                                <td data-label="Donatur" class="cell-title">
                                    <div class="fw-semibold text-truncate" style="max-width: 180px;">
                                        {{ $p->nama_lengkap_donatur }}
                                    </div>
                                    <div class="text-muted small" style="font-size: 11px;">
                                        {{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </td>
                                <td data-label="Jenis">
                                    <span class="badge badge-gold" style="font-size: 11px;">
                                        {{ $p->jenisPersembahan->nama ?? 'Umum' }}
                                    </span>
                                </td>
                                <td data-label="Nominal">
                                    <span class="fw-bold text-success" style="font-size: 13px;">
                                        Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted" style="padding: 30px;">
                                    Belum ada transaksi persembahan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Action Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tugas &amp; Pelayanan Majelis</div>
        </div>
        <div class="card-body">
            <p class="text-muted small mb-3">Akses cepat menu pelayanan jemaat, validasi pendaftaran, jadwal ibadah, serta publikasi warta jemaat.</p>
            <div class="d-flex gap-2" style="flex-direction: column;">
                <a href="{{ route('majelis.pendaftaran.index') }}" class="btn btn-primary w-100 justify-content-between">
                    <span>⌛ Persetujuan Pendaftaran Jemaat</span>
                    <span class="badge badge-warning" style="background:#fff; color:var(--primary);">{{ $pendingPendaftaran }}</span>
                </a>
                <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-accent w-100 justify-content-between">
                    <span>📰 Kelola Warta Jemaat</span>
                    <span class="badge badge-gold" style="background:#fff; color:var(--primary-dark); font-size: 10px;">Tampil di Publik</span>
                </a>
                <a href="{{ route('majelis.jadwal.index') }}" class="btn btn-outline w-100 text-center">
                    📅 Kelola Jadwal Ibadah
                </a>
                <a href="{{ route('majelis.laporan') }}" class="btn btn-success w-100 text-center">
                    📊 Laporan Keuangan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
