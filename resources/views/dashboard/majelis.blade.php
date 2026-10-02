@extends('layouts.app')

@section('title', 'Dashboard Majelis')
@section('header-title', 'Dashboard Majelis')

@section('content')
<div class="page-header">
    <div class="page-header-title">Shalom, Majelis Jemaat</div>
    <div class="breadcrumb">Hari ini: <span class="fw-semibold">{{ now()->translatedFormat('d F Y') }}</span></div>
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
            <div class="stat-label">Pendaftaran Menunggu</div>
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

<div class="grid-2 mb-3">
    <!-- Recent Offerings -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Persembahan Masuk Terbaru</div>
            <a href="{{ route('majelis.laporan') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Donatur</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPersembahan as $p)
                            <tr>
                                <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $p->nama_lengkap_donatur }}</div>
                                </td>
                                <td><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                                <td class="fw-bold">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada transaksi persembahan masuk.</td>
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
            <div class="card-title">Tugas & Pelayanan Majelis</div>
        </div>
        <div class="card-body">
            <p class="text-muted mb-2">Kelola pendaftaran jemaat baru, jadwal ibadah rutin maupun khusus, serta warta/pengumuman jemaat.</p>
            <div class="d-flex gap-2" style="flex-direction: column;">
                <a href="{{ route('majelis.pendaftaran.index') }}" class="btn btn-primary w-100 justify-content-between">
                    <span>⌛ Persetujuan Pendaftaran Jemaat</span>
                    <span class="badge badge-warning" style="background:#fff; color:var(--primary);">{{ $pendingPendaftaran }}</span>
                </a>
                <a href="{{ route('majelis.jadwal.index') }}" class="btn btn-accent w-100 text-center">📅 Kelola Jadwal Ibadah</a>
                <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-outline w-100 text-center">📢 Kelola Warta / Pengumuman</a>
                <a href="{{ route('majelis.laporan') }}" class="btn btn-success w-100 text-center">📊 Laporan Keuangan</a>
            </div>
        </div>
    </div>
</div>
@endsection
