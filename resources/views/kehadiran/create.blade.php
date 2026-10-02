@extends('layouts.app')

@section('title', 'Catat Kehadiran Ibadah')
@section('header-title', 'Kehadiran Ibadah')

@section('content')
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.kehadiran.index') }}">Kehadiran Ibadah</a> &gt; <span>Catat Kehadiran</span>
    </div>
</div>

<div class="card" style="max-width: 650px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Pencatatan Kehadiran Ibadah Baru</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.kehadiran.store') }}">
            @csrf

            <!-- Pilih Ibadah -->
            <div class="form-group">
                <label for="jadwal_ibadah_id" class="form-label">Pilih Ibadah / Kategorial <span class="text-danger">*</span></label>
                <select name="jadwal_ibadah_id" id="jadwal_ibadah_id" class="form-control @error('jadwal_ibadah_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kegiatan Ibadah --</option>
                    @foreach($jadwals as $j)
                        <option value="{{ $j->id }}" {{ old('jadwal_ibadah_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }} ({{ $j->hari ?: 'Insidentil' }} - {{ substr($j->waktu_mulai, 0, 5) }} WIB) 
                            @if($j->kategori)
                                [{{ $j->kategori->nama }}]
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('jadwal_ibadah_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid-2">
                <!-- Tanggal Ibadah -->
                <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h3 class="form-label" style="margin-top: 24px; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 6px; color: var(--accent-dark);">Rincian Kehadiran Jemaat</h3>
            
            <div class="grid-3">
                <!-- Jumlah Pria -->
                <div class="form-group">
                    <label for="jumlah_pria" class="form-label">Jumlah Pria <span class="text-danger">*</span></label>
                    <input type="number" id="jumlah_pria" name="jumlah_pria" class="form-control @error('jumlah_pria') is-invalid @enderror" value="{{ old('jumlah_pria', 0) }}" min="0" required>
                    @error('jumlah_pria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah Wanita -->
                <div class="form-group">
                    <label for="jumlah_wanita" class="form-label">Jumlah Wanita <span class="text-danger">*</span></label>
                    <input type="number" id="jumlah_wanita" name="jumlah_wanita" class="form-control @error('jumlah_wanita') is-invalid @enderror" value="{{ old('jumlah_wanita', 0) }}" min="0" required>
                    @error('jumlah_wanita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah Anak -->
                <div class="form-group">
                    <label for="jumlah_anak" class="form-label">Jumlah Anak <span class="text-danger">*</span></label>
                    <input type="number" id="jumlah_anak" name="jumlah_anak" class="form-control @error('jumlah_anak') is-invalid @enderror" value="{{ old('jumlah_anak', 0) }}" min="0" required>
                    @error('jumlah_anak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div class="form-group" style="margin-top: 12px;">
                <label for="keterangan" class="form-label">Catatan / Keterangan</label>
                <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Contoh: Kondisi cuaca hujan, kendala teknis, dll...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 justify-content-between mt-3" style="border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('majelis.kehadiran.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kehadiran</button>
            </div>
        </form>
    </div>
</div>
@endsection
