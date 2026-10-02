@extends('layouts.app')

@section('title', 'Persembahan Offline')
@section('header-title', 'Persembahan Offline')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">Persembahan Offline</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Persembahan Offline</span>
            </div>
        </div>
        <a href="{{ route('majelis.persembahan-offline.create') }}" class="btn btn-primary">➕ Entri Persembahan</a>
    </div>
</div>

<div class="card mb-3" style="background: var(--card); border: 1px solid var(--border);">
    <div class="card-body" style="padding: 16px 20px;">
        <form method="GET" action="{{ route('majelis.persembahan-offline.index') }}" class="d-flex gap-2 align-items-center" style="flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama donatur, kategori, atau keterangan..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-outline" style="padding: 10px 20px;">Cari</button>
            @if(request('search'))
                <a href="{{ route('majelis.persembahan-offline.index') }}" class="btn btn-outline" style="border-color: transparent;">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Daftar Penerimaan Persembahan Offline</div></div>
    <div class="card-body">
        <div class="table-wrapper table-responsive-stack">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Donatur</th>
                        <th>Kategori</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($persembahans as $p)
                        <tr>
                            <td data-label="ID Transaksi" class="small fw-semibold" style="font-family: monospace; color: var(--text-muted);">{{ $p->order_id }}</td>
                            <td data-label="Donatur" class="cell-title">
                                <div class="fw-semibold" style="font-size: 14.5px; color: var(--primary);">{{ $p->nama_lengkap_donatur }}</div>
                                @if($p->user)
                                    <div class="text-muted small" style="font-style: italic; font-size: 11px;">Jemaat - {{ $p->user->nomor_jemaat }}</div>
                                @else
                                    <div class="text-muted small" style="font-style: italic; font-size: 11px; color: var(--text-light);">Non-Jemaat (Tamu)</div>
                                @endif
                            </td>
                            <td data-label="Kategori"><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                            <td data-label="Nominal" class="fw-bold text-success" style="font-size: 14px;">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td data-label="Metode">
                                @if($p->metode_bayar === 'Tunai')
                                    <span class="badge badge-secondary" style="background:#e3f2fd; color:#0d47a1;">Tunai</span>
                                @else
                                    <span class="badge badge-info" style="background:#f3e5f5; color:#4a148c;">Transfer</span>
                                @endif
                            </td>
                            <td data-label="Tanggal">{{ $p->paid_at ? $p->paid_at->translatedFormat('d F Y') : '-' }}</td>
                            <td data-label="Keterangan" class="text-muted small">
                                {{ $p->keterangan ?: '-' }}
                            </td>
                            <td data-label="Aksi">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('majelis.persembahan-offline.edit', $p->id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                                    
                                    <form method="POST" action="{{ route('majelis.persembahan-offline.destroy', $p->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan persembahan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada catatan persembahan offline yang sesuai pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($persembahans->hasPages())
            <div class="pagination-wrapper">
                {{ $persembahans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
