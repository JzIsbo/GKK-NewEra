@extends('layouts.app')

@section('title', 'Ubah Kegiatan')
@section('header-title', 'Kegiatan')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Ubah Detail Kegiatan</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('kegiatan.index') }}">Kegiatan</a> &gt; <span>Ubah</span>
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
    <div class="card-header"><div class="card-title">Formulir Ubah Kegiatan</div></div>
    <div class="card-body">
        <form method="POST" action="{{ route('kegiatan.update', $kegiatan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Kegiatan -->
            <div class="form-group">
                <label class="form-label" for="nama">Nama Kegiatan <span>*</span></label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $kegiatan->nama) }}" placeholder="Tuliskan nama kegiatan..." required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label class="form-label" for="deskripsi">Deskripsi Kegiatan</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi atau detail susunan kegiatan...">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <!-- Kategori KPK -->
            @if(auth()->user()->hasRole('pengurus_kategorial'))
                <div class="form-group">
                    <label class="form-label">Kategori / Kelompok Persekutuan Kategorial (KPK)</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->kategori->singkatan }} - ({{ auth()->user()->kategori->nama }})" disabled style="background-color: var(--border);">
                    <span class="text-muted small">Otomatis diset sesuai kategori kategorial akun Anda.</span>
                </div>
            @else
                <div class="form-group">
                    <label class="form-label" for="kategori_id">Kategori / Kelompok Persekutuan Kategorial (KPK)</label>
                    <select id="kategori_id" name="kategori_id" class="form-control">
                        <option value="">-- Umum / Semua Jemaat --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $kegiatan->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->singkatan }} - ({{ $kat->nama }})</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="grid-2">
                <!-- Tanggal Mulai -->
                <div class="form-group">
                    <label class="form-label" for="tanggal_mulai">Tanggal & Waktu Mulai <span>*</span></label>
                    <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('Y-m-d\TH:i') : '') }}" required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="form-group">
                    <label class="form-label" for="tanggal_selesai">Tanggal & Waktu Selesai (Opsional)</label>
                    <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>

            <div class="grid-2">
                <!-- Lokasi -->
                <div class="form-group">
                    <label class="form-label" for="lokasi">Lokasi Kegiatan</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control" value="{{ old('lokasi', $kegiatan->lokasi) }}" placeholder="Contoh: Gedung Utama / Ruang Serbaguna">
                </div>

                <!-- Gambar -->
                <div class="form-group">
                    <label class="form-label" for="gambar">Foto / Gambar Pamflet Kegiatan</label>
                    @if($kegiatan->gambar)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $kegiatan->gambar) }}" alt="{{ $kegiatan->nama }}" style="max-width: 120px; border-radius: 6px; border: 1px solid var(--border);">
                            <span class="text-muted small d-block">Gambar saat ini</span>
                        </div>
                    @endif
                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" style="padding: 8px 12px;">
                    <span class="text-muted small">Pilih file baru jika ingin mengganti gambar saat ini. Format: JPG, PNG, GIF. Maks: 2MB.</span>
                </div>
            </div>

            <!-- Checkbox Aktif -->
            <div class="form-group" style="margin-top: 10px;">
                <label class="d-flex align-items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $kegiatan->aktif) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                    <span class="form-label" style="margin-bottom: 0;">Kegiatan Aktif (Ditampilkan pada daftar kegiatan mendatang)</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="mt-3 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui Kegiatan</button>
            </div>
        </form>
    </div>
</div>
@endsection
