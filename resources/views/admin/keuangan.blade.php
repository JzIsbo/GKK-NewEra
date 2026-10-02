@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('header-title', 'Laporan Keuangan')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Laporan Penerimaan Persembahan (Admin)</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Keuangan</span>
    </div>
</div>

<!-- Filter Form -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.keuangan') }}">
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
                    <a href="{{ route('admin.keuangan.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-accent">📥 Unduh PDF</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Stat Grid -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon gold">Rp</div>
        <div>
            <div class="stat-value">Rp {{ number_format($totalSemua, 0, ',', '.') }}</div>
            <div class="stat-label">Total Penerimaan (All Time)</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">Rp</div>
        <div>
            <div class="stat-value">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
            <div class="stat-label">Penerimaan Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">💳</div>
        <div>
            <div class="stat-value">{{ $jumlahTransaksi }}</div>
            <div class="stat-label">Transaksi Berhasil</div>
        </div>
    </div>
</div>

<div class="grid-3 mb-3">
    <!-- Breakdown -->
    <div class="card" style="grid-column: span 1;">
        <div class="card-header"><div class="card-title">Penerimaan Per Jenis</div></div>
        <div class="card-body" style="padding: 16px 24px;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th class="text-end">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perJenis as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item['nama'] }}</td>
                                <td class="text-end fw-bold text-success">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Tidak ada data penerimaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Main Table Detail -->
    <div class="card" style="grid-column: span 2;">
        <div class="card-header"><div class="card-title">Detail Log Penerimaan Persembahan</div></div>
        <div class="card-body" style="padding: 16px 24px;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Order ID</th>
                            <th>Donatur</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($persembahans as $p)
                            <tr>
                                <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y') : '-' }}</td>
                                <td class="fw-semibold">{{ $p->order_id }}</td>
                                <td>
                                    <div>{{ $p->nama_lengkap_donatur }}</div>
                                    <div class="text-muted small" style="font-size: 11px;">{{ $p->email_donatur ?: ($p->user->email ?? '') }}</div>
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada persembahan masuk periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper" style="margin-top: 12px;">
                {{ $persembahans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
