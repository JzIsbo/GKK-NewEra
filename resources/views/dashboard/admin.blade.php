@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header-title', 'Dashboard Administrator')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div>
        <h1 class="page-header-title" style="margin-bottom: 4px;">Selamat Datang, {{ auth()->user()->nama_display }}</h1>
        <div class="breadcrumb">
            <span>Portal Administrator &bull; {{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
    <div class="d-flex gap-2" style="flex-wrap: wrap;">
        <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-accent btn-sm">
            📰 Warta Jemaat
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
            <div class="stat-label">Total Jemaat Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange warning">⌛</div>
        <div>
            <div class="stat-value">{{ number_format($pendingPendaftaran) }}</div>
            <div class="stat-label">
                Pendaftaran Menunggu
                @if($pendingPendaftaran > 0)
                    <span class="badge badge-warning" style="font-size: 10px; margin-left: 4px;">Perlu Review</span>
                @endif
            </div>
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
            <div class="stat-label">Total Persembahan</div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="dashboard-grid">
    <!-- Recent Offerings -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2">
                <div class="card-title">Persembahan Terbaru</div>
                <span class="badge badge-secondary">{{ count($recentPersembahan) }}</span>
            </div>
            <a href="{{ route('admin.keuangan') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Donatur &amp; Waktu</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPersembahan as $p)
                            <tr>
                                <td data-label="Donatur" class="cell-title">
                                    <div class="fw-semibold text-truncate" style="max-width: 170px;" title="{{ $p->nama_lengkap_donatur }}">
                                        {{ $p->nama_lengkap_donatur }}
                                    </div>
                                    <div class="text-muted small" style="font-size: 11px;">
                                        {{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : ($p->created_at ? $p->created_at->format('d/m/Y H:i') : '-') }}
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
                                <td data-label="Status">
                                    @if($p->status === 'success')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($p->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @else
                                        <span class="badge badge-danger">{{ ucfirst($p->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 30px;">
                                    Belum ada transaksi persembahan.
                                </td>
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
            <div class="d-flex align-items-center gap-2">
                <div class="card-title">Pendaftaran Jemaat</div>
                @if($pendingPendaftaran > 0)
                    <span class="badge badge-warning">{{ $pendingPendaftaran }} Menunggu</span>
                @endif
            </div>
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Calon Jemaat</th>
                            <th>Kontak</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPendaftaran as $p)
                            <tr>
                                <td data-label="Calon Jemaat" class="cell-title">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">
                                            {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="fw-semibold text-truncate" style="max-width: 140px;" title="{{ $p->nama_lengkap }}">
                                                {{ $p->nama_lengkap }}
                                            </div>
                                            <div class="text-muted small text-truncate" style="max-width: 140px; font-size: 11px;">
                                                {{ $p->asal_gereja ?: 'Jemaat Baru' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Kontak">
                                    <div class="text-truncate text-muted small" style="max-width: 130px; font-size: 11.5px;" title="{{ $p->email }}">
                                        {{ $p->email }}
                                    </div>
                                    @if($p->no_telepon)
                                        <div class="small fw-semibold" style="font-size: 11px; color: var(--accent-dark);">
                                            {{ $p->no_telepon }}
                                        </div>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    @if($p->status === 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($p->status === 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                    <div class="text-muted" style="font-size: 10.5px; margin-top: 2px;">
                                        {{ $p->created_at->format('d/m/Y') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted" style="padding: 30px;">
                                    Belum ada pendaftaran jemaat baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Admin Actions -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Menu Administrasi Cepat</div>
    </div>
    <div class="card-body">
        <div class="d-flex gap-2" style="flex-wrap: wrap;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="flex: 1 1 150px; justify-content: center;">
                👥 Manajemen User
            </a>
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-warning" style="flex: 1 1 150px; justify-content: center;">
                ⌛ Approval Pendaftaran
            </a>
            <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-accent" style="flex: 1 1 150px; justify-content: center;">
                📰 Warta Jemaat (Publik)
            </a>
            <a href="{{ route('admin.keuangan') }}" class="btn btn-success" style="flex: 1 1 150px; justify-content: center;">
                📊 Laporan Keuangan
            </a>
            <a href="{{ route('majelis.jadwal.index') }}" class="btn btn-outline" style="flex: 1 1 150px; justify-content: center;">
                📅 Jadwal Ibadah
            </a>
            <a href="{{ route('admin.pengaturan') }}" class="btn btn-outline" style="flex: 1 1 150px; justify-content: center;">
                ⚙ Pengaturan Aplikasi
            </a>
        </div>
    </div>
</div>
@endsection
