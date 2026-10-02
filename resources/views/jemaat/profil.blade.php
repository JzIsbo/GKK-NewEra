@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header-title', 'Profil Saya')

@section('styles')
<style>
/* On mobile, the grid-3 with span-2 needs to stack fully */
@media (max-width: 640px) {
    .grid-3 { grid-template-columns: 1fr !important; }
    [style*="grid-column: span 2"] { grid-column: span 1 !important; }
    .text-end { text-align: left !important; }
    .text-end .btn { width: 100%; }
}
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Detail Profil Jemaat</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Profil</span>
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

<div class="grid-3">
    <!-- Left Form Area -->
    <div class="card" style="grid-column: span 2;">
        <div class="card-header"><div class="card-title">Informasi Pribadi</div></div>
        <div class="card-body">
            <form method="POST" action="{{ route('jemaat.profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="nama_lengkap">Nama Lengkap <span>*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap ?: $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email (Akun Login)</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" readonly style="background-color: var(--bg-light); color: var(--text-muted); cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="no_telepon">No. Telepon / WhatsApp</label>
                        <input type="text" id="no_telepon" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="pekerjaan">Pekerjaan</label>
                        <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $user->pekerjaan) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status_pernikahan">Status Pernikahan</label>
                        <select id="status_pernikahan" name="status_pernikahan" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="belum_menikah" {{ old('status_pernikahan', $user->status_pernikahan) === 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="menikah" {{ old('status_pernikahan', $user->status_pernikahan) === 'menikah' ? 'selected' : '' }}>Menikah</option>
                            <option value="duda" {{ old('status_pernikahan', $user->status_pernikahan) === 'duda' ? 'selected' : '' }}>Duda</option>
                            <option value="janda" {{ old('status_pernikahan', $user->status_pernikahan) === 'janda' ? 'selected' : '' }}>Janda</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="alamat">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="foto">Unggah Foto Profil Baru</label>
                    <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                    <span class="text-muted small">Format gambar JPG, PNG, atau WEBP dengan ukuran maks 2 MB.</span>
                </div>

                <div class="mt-2 text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Profile Status Area -->
    <div>
        <div class="card mb-2">
            <div class="card-header"><div class="card-title">Foto Jemaat</div></div>
            <div class="card-body text-center">
                <div class="mb-2">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent);">
                    @else
                        <div style="width: 140px; height: 140px; border-radius: 50%; background-color: var(--primary); color: #fff; font-size: 60px; font-weight: bold; line-height: 140px; display: inline-block;">
                            {{ strtoupper(substr($user->nama_display, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="fw-bold" style="font-size: 16px;">{{ $user->nama_display }}</div>
                <div class="text-muted small">{{ $user->email }}</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-title">Status Jemaat</div></div>
            <div class="card-body">
                <div class="mb-2">
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; font-weight: 600;">Nomor Jemaat</div>
                    <div class="fw-bold" style="font-size: 16px; color: var(--primary);">{{ $user->nomor_jemaat ?: 'BELUM ADA' }}</div>
                </div>
                <div class="mb-2">
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; font-weight: 600;">Status Keanggotaan</div>
                    <div class="mt-1">
                        @if($user->status_keanggotaan === 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($user->status_keanggotaan === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Non-Aktif</span>
                        @endif
                    </div>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; font-weight: 600;">Kategori Persekutuan</div>
                    <div class="fw-semibold" style="font-size: 14px; margin-top: 4px;">{{ $user->kategori->nama ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
