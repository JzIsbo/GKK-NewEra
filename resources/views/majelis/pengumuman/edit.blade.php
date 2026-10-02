@extends('layouts.app')

@section('title', 'Edit Warta Jemaat')
@section('header-title', 'Warta Jemaat')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Edit Warta Jemaat</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.pengumuman.index') }}">Warta Jemaat</a> &gt; <span>Edit</span>
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
    <div class="card-header">
        <div class="card-title">Edit Detail Warta &amp; Publikasi</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.pengumuman.update', $pengumuman->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="judul">Judul Warta Jemaat <span>*</span></label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul', $pengumuman->judul) }}" required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="tipe">Kategori Warta <span>*</span></label>
                    <select id="tipe" name="tipe" class="form-control">
                        <option value="umum" {{ old('tipe', $pengumuman->tipe) === 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="penting" {{ old('tipe', $pengumuman->tipe) === 'penting' ? 'selected' : '' }}>Penting (Sorotan Merah)</option>
                        <option value="kegiatan" {{ old('tipe', $pengumuman->tipe) === 'kegiatan' ? 'selected' : '' }}>Kegiatan / Agenda</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tanggal_mulai">Tanggal Mulai Tayang <span>*</span></label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai ? $pengumuman->tanggal_mulai->format('Y-m-d') : '') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="tanggal_selesai">Tanggal Selesai Tayang (Opsional)</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai ? $pengumuman->tanggal_selesai->format('Y-m-d') : '') }}">
                <span class="text-muted small">Kosongkan jika ingin terus menampilkan warta ini di halaman publik.</span>
            </div>

            <div class="form-group">
                <label class="form-label" for="isi">Isi Warta Jemaat <span>*</span></label>
                <textarea id="isi" name="isi" class="form-control" rows="8" required>{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>

            <div class="form-group">
                <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $pengumuman->aktif) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                    <span class="form-label" style="margin-bottom: 0;">
                        <strong>Publikasikan ke Halaman Utama</strong> (Tampil di bagian Warta Jemaat website publik)
                    </span>
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
