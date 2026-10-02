@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('header-title', 'Laporan Keuangan')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Laporan Keuangan Persembahan</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Laporan Keuangan</span>
    </div>
</div>

<!-- Filter Form -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('majelis.laporan') }}">
            <div class="d-flex gap-3 align-items-center" style="flex-wrap: wrap;">
                <div class="form-group mb-0" style="min-width: 150px;">
                    <label class="form-label" for="bulan">Bulan</label>
                    <select id="bulan" name="bulan" class="form-control">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group mb-0" style="min-width: 150px;">
                    <label class="form-label" for="tahun">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div style="margin-top: 22px;">
                    <button type="submit" class="btn btn-primary">Filter Laporan</button>
                    <a href="{{ route('majelis.laporan.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-accent">📥 Unduh PDF</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="grid-3 mb-3">
    <!-- Stat Card Total -->
    <div class="card" style="grid-column: span 1;">
        <div class="card-header"><div class="card-title">Total Persembahan</div></div>
        <div class="card-body text-center" style="padding: 36px 24px;">
            <div class="text-muted small mb-1" style="text-transform: uppercase; letter-spacing: 0.05em;">Periode {{ Carbon\Carbon::create(null, $bulan)->translatedFormat('F') }} {{ $tahun }}</div>
            <div class="fw-bold text-success" style="font-size: 26px;">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Breakdown by category -->
    <div class="card" style="grid-column: span 2;">
        <div class="card-header"><div class="card-title">Breakdown Per Jenis Persembahan</div></div>
        <div class="card-body" style="padding: 16px 24px;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Jenis Persembahan</th>
                            <th class="text-end">Total Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($totalPerJenis as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item['nama'] }}</td>
                                <td class="text-end fw-bold text-success">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Tidak ada data breakdown.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Main Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Detail Transaksi Persembahan Masuk</div>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Bayar</th>
                        <th>Order ID</th>
                        <th>Nama Donatur</th>
                        <th>Jenis Persembahan</th>
                        <th>Nominal</th>
                        <th>Metode Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($persembahans as $p)
                        <tr>
                            <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="fw-semibold">{{ $p->order_id }}</td>
                            <td>
                                <div>{{ $p->nama_lengkap_donatur }}</div>
                                <div class="text-muted small">{{ $p->email_donatur ?: ($p->user->email ?? '-') }}</div>
                            </td>
                            <td><span class="badge badge-gold">{{ $p->jenisPersembahan->nama ?? '-' }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td style="text-transform: uppercase;">{{ str_replace('_', ' ', $p->metode_bayar ?: '-') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada transaksi persembahan masuk untuk periode ini.</td>
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
