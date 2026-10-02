@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header-title', 'Dashboard Administrator')

@section('content')
<div class="page-header">
    <div class="page-header-title">Selamat Datang, {{ auth()->user()->nama_display }}</div>
    <div class="breadcrumb">Hari ini: <span class="fw-semibold">{{ now()->translatedFormat('d F Y') }}</span></div>
</div>

<!-- Stat Cards -->
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
            <div class="stat-label">Pending Pendaftaran</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">Rp</div>
        <div>
            <div class="stat-value">{{ number_format($persembahanBulanIni, 0, ',', '.') }}</div>
            <div class="stat-label">Persembahan Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold">Rp</div>
        <div>
            <div class="stat-value">{{ number_format($totalPersembahan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Persembahan (All Time)</div>
        </div>
    </div>
</div>

<div class="grid-2 mb-3">
    <!-- Recent Offerings -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Persembahan Terbaru</div>
            <a href="{{ route('admin.keuangan') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPersembahan as $p)
                            <tr>
                                <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $p->nama_lengkap_donatur }}</div>
                                    <div class="text-muted small">{{ $p->email_donatur ?: ($p->user->email ?? '-') }}</div>
                                </td>
                                <td><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                                <td class="fw-bold">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada transaksi persembahan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Pendaftaran Jemaat Terbaru</div>
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Tgl Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPendaftaran as $p)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                                    <div class="text-muted small">Asal: {{ $p->asal_gereja ?: '-' }}</div>
                                </td>
                                <td>
                                    <div>{{ $p->email }}</div>
                                    <div class="text-muted small">{{ $p->no_telepon }}</div>
                                </td>
                                <td>
                                    @if($p->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($p->status === 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada pendaftaran jemaat baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Menu Administrasi Cepat</div></div>
    <div class="card-body">
        <div class="d-flex gap-3" style="flex-wrap: wrap;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">👥 Manajemen User</a>
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-warning">⌛ Approval Pendaftaran</a>
            <a href="{{ route('admin.keuangan') }}" class="btn btn-success">📊 Laporan Keuangan</a>
            <a href="{{ route('admin.pengaturan') }}" class="btn btn-accent">⚙ Pengaturan Aplikasi</a>
        </div>
    </div>
</div>
@endsection
