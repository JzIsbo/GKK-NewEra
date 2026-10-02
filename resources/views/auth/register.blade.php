@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
<h1 class="card-title">Buat Akun</h1>
<p class="card-sub">Daftar sebagai anggota portal GEMINDO Kawan Kasih</p>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
</div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="nama_lengkap">Nama Lengkap <span style="color:#dc2626">*</span></label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
               value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap sesuai KTP" required>
        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="email">Alamat Email <span style="color:#dc2626">*</span></label>
        <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email') }}" placeholder="email@example.com" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="no_telepon">No. Telepon / WhatsApp <span style="color:#dc2626">*</span></label>
        <input type="text" id="no_telepon" name="no_telepon" class="form-control {{ $errors->has('no_telepon') ? 'is-invalid' : '' }}"
               value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx" required>
        @error('no_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password <span style="color:#dc2626">*</span></label>
        <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
               placeholder="Minimal 8 karakter" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Password <span style="color:#dc2626">*</span></label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
    </div>

    <button type="submit" class="btn-submit">Buat Akun</button>
</form>

<div class="divider"><span>atau</span></div>
<p style="text-align:center; font-size:13px; color:#64748b;">
    Sudah punya akun? <a href="{{ route('login') }}" class="text-link">Masuk di sini</a>
</p>
<p style="text-align:center; font-size:13px; color:#64748b; margin-top:8px;">
    Ingin daftar sebagai jemaat baru? <a href="{{ route('daftar-jemaat') }}" class="text-link">Formulir Pendaftaran Jemaat →</a>
</p>
@endsection
