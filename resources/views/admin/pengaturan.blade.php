@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')
@section('header-title', 'Pengaturan Aplikasi')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Pengaturan Profil & Informasi Gereja</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pengaturan</span>
    </div>
</div>

<form method="POST" action="{{ route('admin.pengaturan.update') }}">
    @csrf

    <div class="grid-2 mb-3">
        <!-- Card 1: Profil Gereja -->
        <div class="card">
            <div class="card-header"><div class="card-title">Profil & Informasi Utama</div></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="nama_gereja">Nama Gereja <span>*</span></label>
                    <input type="text" id="nama_gereja" name="nama_gereja" class="form-control" value="{{ old('nama_gereja', $settings['nama_gereja'] ?? 'GEMINDO Kawan Kasih') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nama_pendeta">Nama Pendeta Jemaat</label>
                    <input type="text" id="nama_pendeta" name="nama_pendeta" class="form-control" value="{{ old('nama_pendeta', $settings['nama_pendeta'] ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="tentang_gereja">Tentang Gereja (Visi & Misi)</label>
                    <textarea id="tentang_gereja" name="tentang_gereja" class="form-control" rows="4">{{ old('tentang_gereja', $settings['tentang_gereja'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Kontak & Lokasi -->
        <div class="card">
            <div class="card-header"><div class="card-title">Kontak & Lokasi</div></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="telepon_gereja">Nomor Telepon / WA Gereja</label>
                    <input type="text" id="telepon_gereja" name="telepon_gereja" class="form-control" value="{{ old('telepon_gereja', $settings['telepon_gereja'] ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email_gereja">Alamat Email Resmi</label>
                    <input type="email" id="email_gereja" name="email_gereja" class="form-control" value="{{ old('email_gereja', $settings['email_gereja'] ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="alamat_gereja">Alamat Fisik Gereja</label>
                    <textarea id="alamat_gereja" name="alamat_gereja" class="form-control" rows="4">{{ old('alamat_gereja', $settings['alamat_gereja'] ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-2 mb-3">
        <!-- Card 3: Rekening & Keuangan -->
        <div class="card">
            <div class="card-header"><div class="card-title">Rekening Bank & QRIS</div></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="rekening_gereja">Detail Nomor Rekening Bank</label>
                    <textarea id="rekening_gereja" name="rekening_gereja" class="form-control" rows="4" placeholder="Contoh:&#10;Bank Central Asia (BCA)&#10;No. Rek: 1234567890&#10;a.n. GEMINDO Kawan Kasih">{{ old('rekening_gereja', $settings['rekening_gereja'] ?? '') }}</textarea>
                    <span class="text-muted small">Detail ini akan ditampilkan di halaman depan menu pembayaran persembahan.</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Media Sosial -->
        <div class="card">
            <div class="card-header"><div class="card-title">Media Sosial</div></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="facebook_url">URL Facebook Page</label>
                    <input type="url" id="facebook_url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/...">
                </div>

                <div class="form-group">
                    <label class="form-label" for="instagram_url">URL Instagram</label>
                    <input type="url" id="instagram_url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/...">
                </div>

                <div class="form-group">
                    <label class="form-label" for="youtube_url">URL YouTube Channel</label>
                    <input type="url" id="youtube_url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/...">
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <button type="submit" class="btn btn-primary" style="padding: 12px 36px;">Simpan Semua Pengaturan</button>
    </div>
</form>
@endsection
