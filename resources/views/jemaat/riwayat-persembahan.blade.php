@extends('layouts.app')

@section('title', 'Riwayat Persembahan')
@section('header-title', 'Riwayat Persembahan')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Riwayat Persembahan Saya</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Riwayat Persembahan</span>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Transaksi Persembahan Anda</div>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Transaksi</th>
                        <th>Order ID</th>
                        <th>Jenis Persembahan</th>
                        <th>Nominal</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($persembahans as $p)
                        <tr>
                            <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : ($p->created_at ? $p->created_at->format('d/m/Y H:i') : '-') }}</td>
                            <td><span class="fw-semibold">{{ $p->order_id }}</span></td>
                            <td><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                            <td class="fw-bold">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td style="text-transform: uppercase;">{{ str_replace('_', ' ', $p->metode_bayar ?: '-') }}</td>
                            <td>
                                @if($p->status === 'success')
                                    <span class="badge badge-success">Selesai</span>
                                @elseif($p->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Gagal</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status === 'success')
                                    <a href="{{ route('persembahan.bukti', $p->order_id) }}" class="btn btn-accent btn-sm">📥 Unduh Bukti PDF</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada catatan persembahan digital Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $persembahans->links() }}
        </div>
    </div>
</div>
@endsection
