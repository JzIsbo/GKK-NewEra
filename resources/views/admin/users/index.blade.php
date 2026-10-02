@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header-title', 'Manajemen User')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Manajemen Data Pengguna</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>User</span>
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
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Jemaat</th>
                        <th>Nama Lengkap</th>
                        <th>Email / Kontak</th>
                        <th>Role / Hak Akses</th>
                        <th>Status</th>
                        <th>Terdaftar Pada</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td class="fw-semibold">{{ $u->nomor_jemaat ?: '-' }}</td>
                            <td>
                                <div class="fw-bold">{{ $u->nama_lengkap ?: $u->name }}</div>
                            </td>
                            <td>
                                <div>{{ $u->email }}</div>
                                <div class="text-muted small">{{ $u->no_telepon ?: '-' }}</div>
                            </td>
                            <td>
                                @foreach($u->roles as $role)
                                    <span class="badge badge-info" style="margin-bottom: 2px;">{{ ucfirst($role->name) }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($u->status_keanggotaan === 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($u->status_keanggotaan === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ $u->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-outline">Detail</a>
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-accent">Edit</a>
                                    
                                    @if(!$u->hasRole('super_admin'))
                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait juga akan terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data pengguna ditemukan.</td>
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
