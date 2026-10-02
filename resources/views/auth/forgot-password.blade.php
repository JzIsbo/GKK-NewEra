@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<h1 class="card-title">Lupa Password?</h1>
<p class="card-sub">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.</p>

@if (session('status'))
    <div class="alert alert-success">✓ {{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-submit">Kirim Tautan Reset Password</button>
</form>

<div class="divider"><span>atau</span></div>

<p style="text-align:center; font-size:13px; color:#64748b;">
    Sudah ingat password Anda?<br>
    <a href="{{ route('login') }}" class="text-link">← Kembali ke halaman masuk</a>
</p>
@endsection
