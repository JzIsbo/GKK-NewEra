@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('header-title', 'Manajemen User')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Edit Data Pengguna</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('admin.users.index') }}">User</a> &gt; <span>Edit</span>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul style="padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header"><div class="card-title">Edit Formulir Pengguna: {{ $user->nama_display }}</div></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="nama_lengkap">Nama Lengkap <span>*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap ?: $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email <span>*</span></label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_telepon">No. Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="status_keanggotaan">Status Keanggotaan <span>*</span></label>
                    <select id="status_keanggotaan" name="status_keanggotaan" class="form-control" required>
                        <option value="aktif" {{ old('status_keanggotaan', $user->status_keanggotaan) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ old('status_keanggotaan', $user->status_keanggotaan) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="non-aktif" {{ old('status_keanggotaan', $user->status_keanggotaan) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Hak Akses / Role <span>*</span></label>
                    <select id="role" name="role" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', $user->roles->first()->name ?? '') === $role->name ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="kategori_id">Kelompok Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-control">
                        <option value="">-- Tanpa Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $user->kategori_id) == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi Baru (Opsional)</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group">
                    <label class="form-label" for="nomor_jemaat">Nomor Jemaat (Read-Only)</label>
                    <input type="text" id="nomor_jemaat" class="form-control" value="{{ $user->nomor_jemaat ?: '-' }}" readonly style="background-color: var(--bg-light); color: var(--text-muted);">
                </div>
            </div>

            <div class="mt-3 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
