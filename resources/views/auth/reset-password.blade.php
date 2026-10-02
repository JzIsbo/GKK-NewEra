@extends('layouts.guest')

@section('title', 'Atur Ulang Password')

@section('content')
<h1 class="card-title">Atur Ulang Password</h1>
<p class="card-sub">Masukkan password baru Anda di bawah ini.</p>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email', $request->email) }}" placeholder="email@example.com" required autofocus>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password Baru</label>
        <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
               placeholder="Minimal 8 karakter" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
               placeholder="Ulangi password baru" required>
        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-submit">Simpan Password Baru</button>
</form>
@endsection
