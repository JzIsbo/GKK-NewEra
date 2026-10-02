@extends('layouts.app')

@section('title', 'Warta & Pengumuman')
@section('header-title', 'Pengumuman')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">Manajemen Warta & Pengumuman</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pengumuman</span>
            </div>
        </div>
        <a href="{{ route('majelis.pengumuman.create') }}" class="btn btn-primary">➕ Tambah Pengumuman</a>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Daftar Pengumuman Aktif & Arsip</div></div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Judul Pengumuman</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status Layar</th>
                        <th>Penulis</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumans as $p)
                        <tr>
                            <td class="fw-semibold">
                                <div>{{ $p->judul }}</div>
                                <div class="text-muted small fw-normal">{{ Str::limit($p->isi, 80) }}</div>
                            </td>
                            <td>{{ $p->tanggal_mulai ? $p->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                            <td>{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : 'Selamanya' }}</td>
                            <td>
                                @if($p->aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Draft / Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $p->penulis->name ?? 'Staf / Majelis' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('majelis.pengumuman.edit', $p->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                    
                                    <form method="POST" action="{{ route('majelis.pengumuman.destroy', $p->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada warta atau pengumuman yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
