@extends('layouts.app')

@section('title', 'Kategori Persembahan')
@section('header-title', 'Kategori Persembahan')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">Kategori Persembahan</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Kategori Persembahan</span>
            </div>
        </div>
        <a href="{{ route('majelis.jenis-persembahan.create') }}" class="btn btn-primary">➕ Tambah Kategori</a>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Daftar Kategori Persembahan</div></div>
    <div class="card-body">
        <div class="table-wrapper">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                        <tr>
                            <td data-label="Nama Kategori" class="fw-semibold cell-title" style="font-size: 15px;">{{ $item->nama }}</td>
                            <td data-label="Deskripsi" class="text-muted">{{ $item->deskripsi ?: 'Tidak ada deskripsi' }}</td>
                            <td data-label="Status">
                                @if($item->aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td data-label="Aksi">
                                <div class="table-actions">
                                    <a href="{{ route('majelis.jenis-persembahan.edit', $item->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                    
                                    <form method="POST" action="{{ route('majelis.jenis-persembahan.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus/menonaktifkan kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted" style="padding: 30px;">Belum ada kategori persembahan. Silakan buat baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kategori->hasPages())
            <div class="pagination-wrapper">
                {{ $kategori->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
