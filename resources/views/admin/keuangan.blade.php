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
                <table class="table-responsive-stack">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th class="text-end">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perJenis as $item)
                            <tr>
                                <td data-label="Jenis" class="fw-semibold cell-title">{{ $item['nama'] }}</td>
                                <td data-label="Nominal" class="text-end fw-bold" style="color: var(--burgundy);">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted" style="padding: 20px;">Tidak ada data penerimaan.</td>
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
            <div class="table-wrapper table-responsive-stack">
                <table class="table-responsive-stack">
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
                                <td data-label="Tanggal">{{ $p->paid_at ? $p->paid_at->format('d/m/Y') : '-' }}</td>
                                <td data-label="Order ID"><span class="badge badge-gold" style="font-size: 11px;">{{ $p->order_id }}</span></td>
                                <td data-label="Donatur" class="cell-title">
                                    <div class="fw-semibold" style="font-size: 14.5px; color: var(--primary);">{{ $p->nama_lengkap_donatur }}</div>
                                    <div class="text-muted small user-email-text" style="font-size: 11px;">{{ $p->email_donatur ?: ($p->user->email ?? '') }}</div>
                                </td>
                                <td data-label="Nominal" class="fw-bold text-success" style="font-size: 14px;">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                <td data-label="Status"><span class="badge badge-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding: 24px;">Belum ada persembahan masuk periode ini.</td>
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
