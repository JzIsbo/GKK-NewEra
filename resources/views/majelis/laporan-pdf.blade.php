<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Persembahan - {{ $bulan }}/{{ $tahun }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.3;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1a2744;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .logo-cross {
            font-size: 26px;
            color: #d4a017;
            font-weight: bold;
        }
        .church-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a2744;
        }
        .report-title {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            color: #1a2744;
        }
        .report-period {
            text-align: right;
            font-size: 10px;
            color: #d4a017;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 14px;
            margin-bottom: 20px;
        }
        .summary-title {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #16a34a;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #1a2744;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 8px 10px;
            border: 1px solid #1a2744;
            text-align: left;
        }
        .data-table td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
        .footer-info {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 40px; text-align: center; vertical-align: middle;">
                <span class="logo-cross">✝</span>
            </td>
            <td>
                <div class="church-title">{{ $namaGereja }}</div>
                <div style="font-size: 9px; color: #64748b;">Laporan Keuangan Penerimaan Digital</div>
            </td>
            <td>
                <div class="report-title">LAPORAN PENERIMAAN PERSEMBAHAN</div>
                <div class="report-period">
                    Periode: {{ Carbon\Carbon::create(null, $bulan)->translatedFormat('F') }} {{ $tahun }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Summary Total -->
    <div class="summary-box">
        <div class="summary-title">Total Penerimaan Bulan Ini</div>
        <div class="summary-value">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
    </div>

    <!-- Main Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">ID Transaksi</th>
                <th style="width: 25%;">Nama Donatur</th>
                <th style="width: 15%;">Jenis Persembahan</th>
                <th style="width: 10%;" class="text-right">Nominal</th>
                <th style="width: 10%;">Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse($persembahans as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y H:i') : '-' }}</td>
                    <td class="fw-bold">{{ $p->order_id }}</td>
                    <td>
                        <div>{{ $p->nama_lengkap_donatur }}</div>
                        <div style="font-size: 8px; color: #64748b;">{{ $p->email_donatur ?: ($p->user->email ?? '') }}</div>
                    </td>
                    <td>{{ $p->jenisPersembahan->nama ?? '-' }}</td>
                    <td class="text-right fw-bold" style="color: #16a34a;">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                    <td style="text-transform: uppercase;">{{ str_replace('_', ' ', $p->metode_bayar ?: '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="color: #64748b; padding: 20px;">Belum ada transaksi persembahan masuk untuk periode ini.</td>
                </tr>
            @endforelse
            @if($persembahans->isNotEmpty())
                <tr>
                    <td colspan="5" class="text-right fw-bold" style="background-color: #f1f5f9;">TOTAL PENERIMAAN:</td>
                    <td class="text-right fw-bold" style="background-color: #f1f5f9; color: #16a34a; font-size: 12px;">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</td>
                    <td style="background-color: #f1f5f9;"></td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer-info">
        Laporan ini dicetak secara otomatis pada tanggal: {{ now()->translatedFormat('d F Y H:i') }} WIB
    </div>

</body>
</html>
