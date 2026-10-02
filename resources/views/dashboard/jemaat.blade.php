@extends('layouts.app')

@section('title', 'Dashboard Jemaat')
@section('header-title', 'Dashboard Jemaat')

@section('content')
<div class="page-header">
    <div class="page-header-title">Shalom, {{ $user->nama_display }}</div>
    <div class="breadcrumb">Nomor Anggota Jemaat: <span class="fw-semibold">{{ $user->nomor_jemaat ?: 'Belum Ada' }}</span></div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon gold">Rp</div>
        <div>
            <div class="stat-value">Rp {{ number_format($totalPersembahan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Persembahan Selesai</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">📜</div>
        <div>
            <div class="stat-value">{{ $riwayatPersembahan->where('status', 'success')->count() }}</div>
            <div class="stat-label">Transaksi Persembahan Sukses</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Recent Offerings -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Persembahan Terakhir Anda</div>
            <a href="{{ route('jemaat.riwayat-persembahan') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body">
            <div class="table-wrapper">
                <table class="table-responsive-stack">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Persembahan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPersembahan as $p)
                            <tr>
                                <td data-label="Tanggal">{{ $p->paid_at ? $p->paid_at->format('d/m/Y') : ($p->created_at ? $p->created_at->format('d/m/Y') : '-') }}</td>
                                <td data-label="Jenis Persembahan" class="cell-title"><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                                <td data-label="Nominal" class="fw-bold" style="color: var(--burgundy);">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td data-label="Status">
                                    @if($p->status === 'success')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($p->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 30px;">Belum ada riwayat persembahan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Member Card Area -->
    <div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: #fff;">
        <div class="card-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="card-title" style="color: #fff;">Kartu Anggota Jemaat</div>
            <a href="{{ route('jemaat.kartu') }}" class="btn btn-accent btn-sm" target="_blank">Unduh PDF</a>
        </div>
        <div class="card-body" style="position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; bottom: -30px; font-size: 140px; color: rgba(255, 255, 255, 0.03); font-weight: bold; pointer-events: none;">✝</div>
            <div class="mb-3">
                <div style="font-size: 11px; text-transform: uppercase; color: var(--accent-light); letter-spacing: 0.05em;">Nomor Anggota</div>
                <div class="fw-bold" style="font-size: 20px;">{{ $user->nomor_jemaat ?: 'GEN-PENDING' }}</div>
            </div>
            <div class="mb-3">
                <div style="font-size: 11px; text-transform: uppercase; color: var(--accent-light); letter-spacing: 0.05em;">Nama Anggota</div>
                <div class="fw-semibold" style="font-size: 16px;">{{ $user->nama_lengkap ?: $user->name }}</div>
            </div>
            <div class="grid-2" style="gap: 10px;">
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--accent-light); letter-spacing: 0.05em;">Status Keanggotaan</div>
                    <div style="font-size: 13.5px;"><span class="badge badge-success" style="background: rgba(22, 163, 74, 0.2); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.3);">{{ ucfirst($user->status_keanggotaan) }}</span></div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--accent-light); letter-spacing: 0.05em;">Kelompok Kategori</div>
                    <div style="font-size: 13.5px;">{{ $user->kategori->nama ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header"><div class="card-title">Aksi Cepat</div></div>
    <div class="card-body">
        <div class="d-flex gap-3" style="flex-wrap: wrap;">
            <a href="{{ route('persembahan.index') }}" class="btn btn-primary">💸 Persembahan Online</a>
            <a href="{{ route('jemaat.profil') }}" class="btn btn-outline">👤 Perbarui Profil</a>
            <a href="{{ route('jemaat.riwayat-persembahan') }}" class="btn btn-outline">📜 Riwayat Persembahan</a>
        </div>
    </div>
</div>
@endsection
