@extends('layouts.app')

@section('title', 'Tulis Warta Jemaat')
@section('header-title', 'Warta Jemaat')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Tulis Warta Jemaat Baru</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.pengumuman.index') }}">Warta Jemaat</a> &gt; <span>Tambah</span>
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
        <div class="card-title">Formulir Warta Jemaat &amp; Publikasi</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.pengumuman.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="judul">Judul Warta Jemaat <span>*</span></label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Tuliskan judul warta jemaat yang jelas..." required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="tipe">Kategori Warta <span>*</span></label>
                    <select id="tipe" name="tipe" class="form-control">
                        <option value="umum" {{ old('tipe') === 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="penting" {{ old('tipe') === 'penting' ? 'selected' : '' }}>Penting (Sorotan Merah)</option>
                        <option value="kegiatan" {{ old('tipe') === 'kegiatan' ? 'selected' : '' }}>Kegiatan / Agenda</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tanggal_mulai">Tanggal Mulai Tayang <span>*</span></label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="tanggal_selesai">Tanggal Selesai Tayang (Opsional)</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                <span class="text-muted small">Kosongkan jika ingin terus menampilkan warta ini di halaman publik.</span>
            </div>

            <div class="form-group">
                <label class="form-label" for="isi">Isi Warta Jemaat <span>*</span></label>
                <textarea id="isi" name="isi" class="form-control" rows="8" placeholder="Tuliskan detail pengumuman atau warta secara lengkap..." required>{{ old('isi') }}</textarea>
            </div>

            <div class="form-group">
                <label class="d-flex align-items-center gap-2" style="cursor: pointer;">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', '1') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                    <span class="form-label" style="margin-bottom: 0;">
                        <strong>Langsung Terbitkan ke Halaman Publik</strong> (Warta akan segera muncul di bagian "Warta Jemaat" halaman depan)
                    </span>
                </label>
            </div>

            <div class="mt-3 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('majelis.pengumuman.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan &amp; Terbitkan Warta</button>
            </div>
        </form>
    </div>
</div>
@endsection
