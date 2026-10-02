@extends('layouts.app')

@section('title', 'Edit Pengumuman')
@section('header-title', 'Pengumuman')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Edit Pengumuman</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.pengumuman.index') }}">Pengumuman</a> &gt; <span>Edit</span>
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
    <div class="card-header"><div class="card-title">Edit Detail Pengumuman</div></div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.pengumuman.update', $pengumuman->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="judul">Judul Pengumuman <span>*</span></label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="isi">Isi Pengumuman <span>*</span></label>
                <textarea id="isi" name="isi" class="form-control" rows="8" required>{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="tanggal_mulai">Tanggal Mulai Ditampilkan <span>*</span></label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai ? $pengumuman->tanggal_mulai->format('Y-m-d') : '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tanggal_selesai">Tanggal Selesai Ditampilkan (Opsional)</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai ? $pengumuman->tanggal_selesai->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="d-flex align-items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $pengumuman->aktif) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                    <span class="form-label" style="margin-bottom: 0;">Pengumuman Aktif (Ditampilkan di halaman depan)</span>
                </label>
            </div>

            <div class="mt-3 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
