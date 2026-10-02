@extends('layouts.app')

@section('title', 'Tambah Jadwal Ibadah')
@section('header-title', 'Jadwal Ibadah')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Tambah Jadwal Ibadah Baru</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.jadwal.index') }}">Jadwal Ibadah</a> &gt; <span>Tambah</span>
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
    <div class="card-header"><div class="card-title">Form Jadwal Ibadah</div></div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.jadwal.store') }}">
            @csrf

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="nama">Nama Kegiatan Ibadah <span>*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Ibadah Raya Minggu Pagi" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="hari">Hari Pelaksanaan <span>*</span></label>
                    <select id="hari" name="hari" class="form-control" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') === $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="waktu_mulai">Waktu Mulai <span>*</span></label>
                    <input type="text" id="waktu_mulai" name="waktu_mulai" class="form-control" value="{{ old('waktu_mulai') }}" placeholder="Format: HH:MM (Contoh: 08:00)" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="waktu_selesai">Waktu Selesai (Opsional)</label>
                    <input type="text" id="waktu_selesai" name="waktu_selesai" class="form-control" value="{{ old('waktu_selesai') }}" placeholder="Format: HH:MM (Contoh: 10:00)">
                </div>

                <div class="form-group">
                    <label class="form-label" for="lokasi">Lokasi Pelaksanaan</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang Ibadah Utama / Zoom">
                </div>

                <div class="form-group">
                    <label class="form-label" for="jenis">Jenis Ibadah</label>
                    <select id="jenis" name="jenis" class="form-control">
                        <option value="reguler" {{ old('jenis') === 'reguler' ? 'selected' : '' }}>Reguler</option>
                        <option value="khusus" {{ old('jenis') === 'khusus' ? 'selected' : '' }}>Khusus</option>
                        <option value="kategorial" {{ old('jenis') === 'kategorial' ? 'selected' : '' }}>Kategorial</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="pelayan_firman">Pelayan Firman</label>
                    <input type="text" id="pelayan_firman" name="pelayan_firman" class="form-control" value="{{ old('pelayan_firman') }}" placeholder="Nama Pendeta / Pengkhotbah">
                </div>

                <div class="form-group">
                    <label class="form-label" for="worship_leader">Worship Leader (WL)</label>
                    <input type="text" id="worship_leader" name="worship_leader" class="form-control" value="{{ old('worship_leader') }}" placeholder="Nama Pemimpin Pujian">
                </div>

                <div class="form-group">
                    <label class="form-label" for="pengajar">Pengajar (Opsional)</label>
                    <input type="text" id="pengajar" name="pengajar" class="form-control" value="{{ old('pengajar') }}" placeholder="Nama Pengajar / Katekis">
                </div>

                <div class="form-group">
                    <label class="form-label" for="pemusik">Pemusik</label>
                    <input type="text" id="pemusik" name="pemusik" class="form-control" value="{{ old('pemusik') }}" placeholder="Nama Pemusik / Organis">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="keterangan">Deskripsi / Keterangan Tambahan</label>
                <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Informasi detail mengenai pelayanan ibadah...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="form-group">
                <label class="d-flex align-items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', '1') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                    <span class="form-label" style="margin-bottom: 0;">Jadwal Ibadah Aktif (Ditampilkan di halaman depan)</span>
                </label>
            </div>

            <div class="mt-3 text-end d-flex gap-2 justify-content-end">
                <a href="{{ route('majelis.jadwal.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection
