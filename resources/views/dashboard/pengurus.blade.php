@extends('layouts.app')

@section('title', 'Dashboard Pengurus')
@section('header-title', 'Dashboard Pengurus Kategorial')

@section('content')
<div class="page-header">
    <div class="page-header-title">Shalom, {{ $user->nama_display }}</div>
    <div class="breadcrumb">Persekutuan Kategorial: <span class="fw-semibold">{{ $kategori->nama ?? 'Semua Kategori' }}</span></div>
</div>

<div class="grid-2">
    <!-- Welcome info -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Pelayanan Kategorial</div>
        </div>
        <div class="card-body">
            @if($kategori)
                <div class="mb-2">
                    <span class="badge badge-gold" style="font-size: 14px; padding: 6px 14px;">{{ $kategori->nama }}</span>
                </div>
                <p class="mb-2">
                    Selamat melayani di Persekutuan Kategorial <strong>{{ $kategori->nama }}</strong>. Anda dapat melihat informasi profil Anda atau melakukan persembahan kasih/perpuluhan secara online melalui portal ini.
                </p>
                <div style="font-size: 13.5px; color: var(--text-muted); line-height: 1.7;">
                    {{ $kategori->deskripsi ?: 'Kelompok persekutuan ini dibentuk untuk mendukung pertumbuhan rohani anggota jemaat sesuai dengan jenjang kategori usia atau kebutuhan pelayanan khusus.' }}
                </div>
            @else
                <p class="text-muted">
                    Akun Anda belum dikaitkan dengan kelompok kategori jemaat tertentu. Silakan hubungi Administrator untuk memperbarui kategori pelayanan Anda.
                </p>
            @endif
        </div>
    </div>

    <!-- Quick Links -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tautan Cepat</div>
        </div>
        <div class="card-body">
            <div class="d-flex gap-3" style="flex-direction: column;">
                <a href="{{ route('persembahan.index') }}" class="btn btn-primary text-center">💸 Persembahan Online</a>
                <a href="{{ route('jemaat.profil') }}" class="btn btn-outline text-center">👤 Edit Profil Saya</a>
                <a href="{{ route('jemaat.riwayat-persembahan') }}" class="btn btn-outline text-center">📜 Riwayat Persembahan Saya</a>
            </div>
        </div>
    </div>
</div>
@endsection
