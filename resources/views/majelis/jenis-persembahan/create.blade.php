@extends('layouts.app')

@section('title', 'Tambah Kategori Persembahan')
@section('header-title', 'Kategori Persembahan')

@section('content')
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.jenis-persembahan.index') }}">Kategori Persembahan</a> &gt; <span>Tambah Kategori</span>
    </div>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Tambah Kategori Persembahan Baru</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.jenis-persembahan.store') }}">
            @csrf

            <div class="form-group">
                <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required placeholder="Contoh: Diakonia Khusus, Persembahan Paskah, dll.">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Keterangan mengenai kategori persembahan ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="d-flex align-items-center gap-3" style="margin-top: 8px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer;">
                        <input type="radio" name="aktif" value="1" checked style="width: 16px; height: 16px; accent-color: var(--accent);"> Aktif
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer;">
                        <input type="radio" name="aktif" value="0" style="width: 16px; height: 16px; accent-color: var(--accent);"> Tidak Aktif
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-between mt-3" style="border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('majelis.jenis-persembahan.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
