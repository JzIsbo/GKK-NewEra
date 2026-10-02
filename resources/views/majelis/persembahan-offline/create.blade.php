@extends('layouts.app')

@section('title', 'Entri Persembahan Offline')
@section('header-title', 'Persembahan Offline')

@section('content')
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <a href="{{ route('majelis.persembahan-offline.index') }}">Persembahan Offline</a> &gt; <span>Entri Persembahan</span>
    </div>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Pencatatan Persembahan Offline Manual</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('majelis.persembahan-offline.store') }}">
            @csrf

            <!-- Tipe Donatur Toggle -->
            <div class="form-group">
                <label class="form-label">Tipe Donatur <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center gap-3" style="margin-top: 8px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer;">
                        <input type="radio" name="tipe_donatur" id="tipeJemaat" value="jemaat" {{ old('tipe_donatur', 'jemaat') === 'jemaat' ? 'checked' : '' }} onclick="toggleDonaturFields()" style="width: 16px; height: 16px; accent-color: var(--accent);">
                        Anggota Jemaat
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer;">
                        <input type="radio" name="tipe_donatur" id="tipeNonJemaat" value="non-jemaat" {{ old('tipe_donatur') === 'non-jemaat' ? 'checked' : '' }} onclick="toggleDonaturFields()" style="width: 16px; height: 16px; accent-color: var(--accent);">
                        Non-Jemaat / Tamu
                    </label>
                </div>
                @error('tipe_donatur')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Jemaat Selection -->
            <div class="form-group" id="jemaatField">
                <label for="user_id" class="form-label">Pilih Anggota Jemaat <span class="text-danger">*</span></label>
                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="">-- Pilih Jemaat --</option>
                    @foreach($jemaats as $jem)
                        <option value="{{ $jem->id }}" {{ old('user_id') == $jem->id ? 'selected' : '' }}>
                            {{ $jem->nama_lengkap ?: $jem->name }} ({{ $jem->nomor_jemaat }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Manual Name Input (if Guest/Non-jemaat) -->
            <div class="form-group" id="manualNameField" style="display: none;">
                <label for="nama_donatur" class="form-label">Nama Donatur / Pengirim <span class="text-danger">*</span></label>
                <input type="text" id="nama_donatur" name="nama_donatur" class="form-control @error('nama_donatur') is-invalid @enderror" value="{{ old('nama_donatur') }}" placeholder="Masukkan nama donatur/pengirim...">
                @error('nama_donatur')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid-2">
                <!-- Kategori Persembahan -->
                <div class="form-group">
                    <label for="jenis_persembahan_id" class="form-label">Kategori Persembahan <span class="text-danger">*</span></label>
                    <select name="jenis_persembahan_id" id="jenis_persembahan_id" class="form-control @error('jenis_persembahan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($jenisPersembahans as $jp)
                            <option value="{{ $jp->id }}" {{ old('jenis_persembahan_id') == $jp->id ? 'selected' : '' }}>
                                {{ $jp->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_persembahan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nominal -->
                <div class="form-group">
                    <label for="nominal" class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                    <input type="number" id="nominal" name="nominal" class="form-control @error('nominal') is-invalid @enderror" value="{{ old('nominal') }}" min="1000" required placeholder="Contoh: 50000">
                    @error('nominal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid-2">
                <!-- Metode Bayar -->
                <div class="form-group">
                    <label for="metode_bayar" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                    <select name="metode_bayar" id="metode_bayar" class="form-control @error('metode_bayar') is-invalid @enderror" required>
                        <option value="Tunai" {{ old('metode_bayar', 'Tunai') === 'Tunai' ? 'selected' : '' }}>Tunai (Amplop/Kotak)</option>
                        <option value="Transfer Manual" {{ old('metode_bayar') === 'Transfer Manual' ? 'selected' : '' }}>Transfer Bank Manual</option>
                    </select>
                    @error('metode_bayar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Penerimaan -->
                <div class="form-group">
                    <label for="paid_at" class="form-label">Tanggal Penerimaan <span class="text-danger">*</span></label>
                    <input type="date" id="paid_at" name="paid_at" class="form-control @error('paid_at') is-invalid @enderror" value="{{ old('paid_at', date('Y-m-d')) }}" required>
                    @error('paid_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div class="form-group">
                <label for="keterangan" class="form-label">Keterangan / Catatan</label>
                <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Tambahkan catatan tambahan (opsional)...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 justify-content-between mt-3" style="border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('majelis.persembahan-offline.index') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Catatan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleDonaturFields() {
    const tipeJemaat = document.getElementById('tipeJemaat');
    const jemaatField = document.getElementById('jemaatField');
    const manualNameField = document.getElementById('manualNameField');
    
    if (tipeJemaat.checked) {
        jemaatField.style.display = 'block';
        manualNameField.style.display = 'none';
        document.getElementById('user_id').required = true;
        document.getElementById('nama_donatur').required = false;
    } else {
        jemaatField.style.display = 'none';
        manualNameField.style.display = 'block';
        document.getElementById('user_id').required = false;
        document.getElementById('nama_donatur').required = true;
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleDonaturFields();
});
</script>
@endsection
