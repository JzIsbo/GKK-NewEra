@extends('layouts.app')

@section('title', 'Dashboard Sekretaris Majelis')
@section('header-title', 'Dashboard Sekretaris Majelis')

@section('content')
<div class="page-header">
    <div class="page-header-title">Shalom, {{ auth()->user()->nama_display }}</div>
    <div class="breadcrumb">Sekretaris Majelis — Hari ini: <span class="fw-semibold">{{ now()->translatedFormat('d F Y') }}</span></div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div>
            <div class="stat-value">{{ number_format($totalJemaat) }}</div>
            <div class="stat-label">Total Jemaat Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange warning">⌛</div>
        <div>
            <div class="stat-value">{{ number_format($pendingPendaftaran) }}</div>
            <div class="stat-label">Pendaftaran Menunggu</div>
        </div>
    </div>
</div>

<div class="grid-2 mb-3">
    <!-- Pending Registrations -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Pendaftaran Jemaat Terbaru</div>
            <a href="{{ route('majelis.pendaftaran.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if($recentPendaftaran->isEmpty())
                <div class="text-center text-muted" style="padding: 30px 0;">
                    <div style="font-size: 40px; margin-bottom: 8px;">📋</div>
                    <p>Belum ada pendaftaran masuk.</p>
                </div>
            @else
                <div class="table-wrapper">
                    <table class="table-responsive-stack">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPendaftaran as $p)
                                <tr>
                                    <td data-label="Nama" class="fw-semibold cell-title">{{ $p->nama_lengkap }}</td>
                                    <td data-label="Status">
                                        @if($p->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($p->status === 'disetujui' || $p->status === 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td data-label="Tanggal">{{ $p->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tugas Sekretaris</div>
        </div>
        <div class="card-body">
            <p class="text-muted mb-2">Sebagai Sekretaris Majelis, Anda mengelola administrasi jemaat dan kegiatan gereja.</p>
            <div class="d-flex gap-2" style="flex-direction: column;">
                <a href="{{ route('majelis.pendaftaran.index') }}" class="btn btn-primary w-100 justify-content-between">
                    <span>⌛ Persetujuan Pendaftaran</span>
                    @if($pendingPendaftaran > 0)
                        <span class="badge" style="background:#fff; color:var(--primary);">{{ $pendingPendaftaran }}</span>
                    @endif
                </a>
                <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-accent w-100 justify-content-between">
                    <span>📰 Kelola Warta Jemaat</span>
                    <span class="badge badge-gold" style="background:#fff; color:var(--primary-dark); font-size: 10px;">Publik</span>
                </a>
                <a href="{{ route('majelis.jadwal.index') }}" class="btn btn-outline w-100 text-center">📅 Kelola Jadwal Ibadah</a>
                <a href="{{ route('majelis.kehadiran.index') }}" class="btn btn-outline w-100 text-center">✅ Data Kehadiran Ibadah</a>
            </div>
        </div>
    </div>
</div>
@endsection
