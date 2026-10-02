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
            <div class="table-wrapper table-responsive-stack">
                <table class="table-responsive-stack">
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
                                <td data-label="Tanggal">{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : '-' }}</td>
                                <td data-label="Donatur" class="cell-title">
                                    <div class="fw-semibold">{{ $p->nama_lengkap_donatur }}</div>
                                    <div class="text-muted small user-email-text">{{ $p->email_donatur ?: ($p->user->email ?? '-') }}</div>
                                </td>
                                <td data-label="Jenis"><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                                <td data-label="Nominal" class="fw-bold text-success">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td data-label="Status"><span class="badge badge-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding: 20px;">Belum ada transaksi persembahan.</td>
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
            <div class="table-wrapper table-responsive-stack">
                <table class="table-responsive-stack">
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
                                <td data-label="Nama" class="cell-title">
                                    <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                                    <div class="text-muted small">Asal: {{ $p->asal_gereja ?: '-' }}</div>
                                </td>
                                <td data-label="Kontak">
                                    <div class="user-contact-info">
                                        <div class="user-email-text">{{ $p->email }}</div>
                                        @if($p->no_telepon)
                                            <div class="text-muted small">{{ $p->no_telepon }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Status">
                                    @if($p->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($p->status === 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td data-label="Tgl Daftar">{{ $p->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 20px;">Belum ada pendaftaran jemaat baru.</td>
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
        <div class="d-flex gap-2" style="flex-wrap: wrap;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="flex: 1 1 140px; justify-content: center;">👥 Manajemen User</a>
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-warning" style="flex: 1 1 140px; justify-content: center;">⌛ Approval Pendaftaran</a>
            <a href="{{ route('admin.keuangan') }}" class="btn btn-success" style="flex: 1 1 140px; justify-content: center;">📊 Laporan Keuangan</a>
            <a href="{{ route('admin.pengaturan') }}" class="btn btn-accent" style="flex: 1 1 140px; justify-content: center;">⚙ Pengaturan Aplikasi</a>
        </div>
    </div>
</div>
@endsection
