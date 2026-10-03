@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header-title', 'Manajemen User')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 class="page-header-title">Manajemen Data Pengguna</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>User</span>
        </div>
    </div>
    <div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Pengguna
        </a>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="d-flex gap-3 align-items-center" style="flex-wrap: wrap;">
                <div class="form-group mb-0" style="flex-grow: 1; min-width: 200px;">
                    <label class="form-label" for="search">Cari Nama / Email / No. Jemaat</label>
                    <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Ketik kata kunci...">
                </div>

                <div class="form-group mb-0" style="min-width: 150px;">
                    <label class="form-label" for="role">Role / Peran</label>
                    <select id="role" name="role" class="form-control">
                        <option value="">-- Semua --</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" {{ request('role') === $r->name ? 'selected' : '' }}>
                                {{ ucfirst($r->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-0" style="min-width: 150px;">
                    <label class="form-label" for="status">Status Keanggotaan</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">-- Semua --</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="non-aktif" {{ request('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div style="margin-top: 22px;">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-body">
        <div class="table-wrapper table-responsive-stack">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nomor Jemaat</th>
                        <th>Nama Lengkap</th>
                        <th>Email / Kontak</th>
                        <th>Role / Hak Akses</th>
                        <th>Status</th>
                        <th>Terdaftar Pada</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                        <tr>
                            <td data-label="No">{{ $users->firstItem() + $index }}</td>
                            <td data-label="Nomor Jemaat"><span class="badge badge-gold" style="font-size: 11px;">{{ $u->nomor_jemaat ?: '-' }}</span></td>
                            <td data-label="Nama Lengkap" class="cell-title">
                                <div class="fw-bold" style="font-size: 14.5px; color: var(--primary);">{{ $u->nama_lengkap ?: $u->name }}</div>
                            </td>
                            <td data-label="Email / Kontak">
                                <div class="user-contact-info">
                                    <div class="user-email-text">{{ $u->email }}</div>
                                    @if($u->no_telepon)
                                        <div class="text-muted small">{{ $u->no_telepon }}</div>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Role / Hak Akses">
                                @foreach($u->roles as $role)
                                    <span class="badge badge-info" style="margin-bottom: 2px;">{{ ucfirst($role->name) }}</span>
                                @endforeach
                            </td>
                            <td data-label="Status">
                                @if($u->status_keanggotaan === 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($u->status_keanggotaan === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td data-label="Terdaftar">{{ $u->created_at->format('d/m/Y') }}</td>
                            <td data-label="Aksi">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-accent">✏️ Edit</a>
                                    
                                    @if(!$u->hasRole('super_admin'))
                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding: 24px;">Tidak ada data pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
