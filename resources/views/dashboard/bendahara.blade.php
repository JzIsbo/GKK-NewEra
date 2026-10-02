@extends('layouts.app')

@section('title', 'Dashboard Bendahara Majelis')
@section('header-title', 'Dashboard Bendahara Majelis')

@section('content')
<div class="page-header">
    <div class="page-header-title">Shalom, {{ auth()->user()->nama_display }}</div>
    <div class="breadcrumb">Bendahara Majelis — Hari ini: <span class="fw-semibold">{{ now()->translatedFormat('d F Y') }}</span></div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon gold">Rp</div>
        <div>
            <div class="stat-value">{{ number_format($persembahanBulanIni, 0, ',', '.') }}</div>
            <div class="stat-label">Persembahan Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">Rp</div>
        <div>
            <div class="stat-value">{{ number_format($persembahanBulanLalu, 0, ',', '.') }}</div>
            <div class="stat-label">Persembahan Bulan Lalu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">Rp</div>
        <div>
            <div class="stat-value">{{ number_format($totalPersembahan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Semua Persembahan</div>
        </div>
    </div>
</div>

<div class="grid-2 mb-3">
    <!-- Recent Offerings -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Persembahan Masuk Terbaru</div>
            <a href="{{ route('majelis.laporan') }}" class="btn btn-outline btn-sm">Laporan Lengkap</a>
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
                                <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $p->nama_lengkap_donatur }}</div>
                                </td>
                                <td><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                                <td class="fw-bold">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada transaksi persembahan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tugas Bendahara</div>
        </div>
        <div class="card-body">
            <p class="text-muted mb-2">Sebagai Bendahara Majelis, Anda mengelola keuangan gereja dan laporan persembahan jemaat.</p>
            <div class="d-flex gap-2" style="flex-direction: column;">
                <a href="{{ route('majelis.laporan') }}" class="btn btn-primary w-100 text-center">📊 Laporan Keuangan Lengkap</a>
                <a href="{{ route('majelis.laporan.export') }}" class="btn btn-accent w-100 text-center">📥 Export Laporan (Excel)</a>
                <a href="{{ route('majelis.persembahan-offline.index') }}" class="btn btn-outline w-100 text-center">💰 Persembahan Offline</a>
                <a href="{{ route('majelis.jenis-persembahan.index') }}" class="btn btn-outline w-100 text-center">🏷️ Kelola Jenis Persembahan</a>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Perbandingan Keuangan Bulanan</div>
    </div>
    <div class="card-body">
        @php
            $diff = $persembahanBulanIni - $persembahanBulanLalu;
            $pct  = $persembahanBulanLalu > 0 ? round(($diff / $persembahanBulanLalu) * 100, 1) : 0;
        @endphp
        <div class="d-flex gap-3" style="flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 160px;">
                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Bulan Ini</div>
                <div style="font-size: 22px; font-weight: 700; color: var(--primary);">Rp {{ number_format($persembahanBulanIni, 0, ',', '.') }}</div>
            </div>
            <div style="flex: 1; min-width: 160px;">
                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Bulan Lalu</div>
                <div style="font-size: 22px; font-weight: 700; color: var(--text-muted);">Rp {{ number_format($persembahanBulanLalu, 0, ',', '.') }}</div>
            </div>
            <div style="flex: 1; min-width: 160px;">
                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Perubahan</div>
                <div style="font-size: 22px; font-weight: 700; color: {{ $diff >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                    {{ $diff >= 0 ? '+' : '' }}{{ $pct }}%
                </div>
                <div style="font-size: 12px; color: var(--text-muted);">{{ $diff >= 0 ? '▲ Naik' : '▼ Turun' }} Rp {{ number_format(abs($diff), 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
