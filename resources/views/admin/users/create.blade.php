@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')
@section('header-title', 'Manajemen User')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Tambah Pengguna Baru</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('admin.users.index') }}">User</a> &gt; <span>Tambah</span>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul style="padding-left: 20px; margin: 0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Formulir Tambah Pengguna Baru</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="nama_lengkap">Nama Lengkap <span>*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap..." required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email <span>*</span></label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@contoh.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi (Password) <span>*</span></label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required minlength="8">
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_telepon">No. Telepon / WhatsApp</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label class="form-label" for="status_keanggotaan">Status Keanggotaan <span>*</span></label>
                    <select id="status_keanggotaan" name="status_keanggotaan" class="form-control" required>
                        <option value="aktif" {{ old('status_keanggotaan', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ old('status_keanggotaan') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="non-aktif" {{ old('status_keanggotaan') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Hak Akses / Peran <span>*</span></label>
                    <select id="role" name="role" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', 'jemaat') === $role->name ? 'selected' : '' }}>
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
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Jemaat</label>
                    <input type="text" class="form-control" value="Otomatis di-generate sistem (GKKxxxxx)" readonly style="background-color: var(--bg-light); color: var(--text-muted); cursor: not-allowed;">
                </div>
            </div>

            <div class="mt-4 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
