@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('header-title', 'Manajemen User')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Detail Pengguna: {{ $user->nama_display }}</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('admin.users.index') }}">User</a> &gt; <span>Detail</span>
    </div>
</div>

<div class="grid-3 mb-3">
    <!-- Profil Card -->
    <div class="card" style="grid-column: span 1;">
        <div class="card-header"><div class="card-title">Foto Profil</div></div>
        <div class="card-body text-center">
            <div class="mb-2">
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Jemaat" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent);">
                @else
                    <div style="width: 130px; height: 130px; border-radius: 50%; background-color: var(--primary); color: #fff; font-size: 56px; font-weight: bold; line-height: 130px; display: inline-block;">
                        {{ strtoupper(substr($user->nama_display, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="fw-bold" style="font-size: 16px;">{{ $user->nama_lengkap ?: $user->name }}</div>
            <div class="text-muted small mb-2">{{ $user->email }}</div>
            <div>
                <span class="badge badge-info">{{ ucfirst($user->roles->first()->name ?? '-') }}</span>
                @if($user->status_keanggotaan === 'aktif')
                    <span class="badge badge-success">Aktif</span>
                @elseif($user->status_keanggotaan === 'pending')
                    <span class="badge badge-warning">Pending</span>
                @else
                    <span class="badge badge-danger">Non-Aktif</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="card" style="grid-column: span 2;">
        <div class="card-header">
            <div class="card-title">Data Lengkap Jemaat</div>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm">Edit Data</a>
        </div>
        <div class="card-body">
            <div class="grid-2">
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Nomor Jemaat:</label>
                    <div class="fw-semibold text-primary" style="font-size: 15px;">{{ $user->nomor_jemaat ?: '-' }}</div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">No. Telepon / WA:</label>
                    <div class="fw-semibold">{{ $user->no_telepon ?: '-' }}</div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Jenis Kelamin:</label>
                    <div class="fw-semibold">{{ $user->jenis_kelamin ? ucfirst($user->jenis_kelamin) : '-' }}</div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Tempat, Tanggal Lahir:</label>
                    <div class="fw-semibold">
                        {{ $user->tempat_lahir ?: '-' }}@if($user->tanggal_lahir), {{ $user->tanggal_lahir->format('d/m/Y') }}@endif
                    </div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Pekerjaan:</label>
                    <div class="fw-semibold">{{ $user->pekerjaan ?: '-' }}</div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Status Pernikahan:</label>
                    <div class="fw-semibold">{{ $user->status_pernikahan ? str_replace('_', ' ', ucfirst($user->status_pernikahan)) : '-' }}</div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Kelompok Kategori:</label>
                    <div class="fw-semibold"><span class="badge badge-gold">{{ $user->kategori->nama ?? '-' }}</span></div>
                </div>
                <div class="form-group mb-1">
                    <label class="form-label" style="margin-bottom: 2px;">Terdaftar Sejak:</label>
                    <div class="fw-semibold">{{ $user->created_at->format('d F Y') }}</div>
                </div>
            </div>
            <div class="form-group mb-1" style="margin-top: 12px;">
                <label class="form-label" style="margin-bottom: 2px;">Alamat Rumah:</label>
                <div class="fw-semibold" style="line-height: 1.5;">{{ $user->alamat ?: '-' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Offering History Card -->
<div class="card">
    <div class="card-header"><div class="card-title">Riwayat Persembahan (Maks 10 Terakhir)</div></div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Transaksi</th>
                        <th>Order ID</th>
                        <th>Jenis Persembahan</th>
                        <th>Nominal</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->persembahans->take(10) as $p)
                        <tr>
                            <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : ($p->created_at ? $p->created_at->format('d/m/Y H:i') : '-') }}</td>
                            <td><span class="fw-semibold">{{ $p->order_id }}</span></td>
                            <td><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td style="text-transform: uppercase;">{{ str_replace('_', ' ', $p->metode_bayar ?: '-') }}</td>
                            <td>
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
                            <td colspan="6" class="text-center text-muted">Belum ada transaksi persembahan tercatat dari user ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
