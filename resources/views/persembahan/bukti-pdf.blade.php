<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Persembahan - {{ $persembahan->order_id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333333;
            line-height: 1.4;
            padding: 10px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1a2744;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-cross {
            font-size: 24px;
            color: #d4a017;
            font-weight: bold;
        }
        .church-title {
            font-size: 16px;
            font-weight: bold;
            color: #1a2744;
        }
        .church-sub {
            font-size: 9px;
            color: #666666;
            margin-top: 2px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #1a2744;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #eeeeee;
        }
        .label {
            color: #666666;
            width: 35%;
        }
        .value {
            font-weight: 500;
            color: #111111;
        }
        .value-bold {
            font-weight: bold;
            color: #16a34a;
            font-size: 13px;
        }
        .footer-table {
            width: 100%;
            margin-top: 30px;
        }
        .thank-you {
            font-style: italic;
            color: #b8891a;
            text-align: center;
            margin-bottom: 10px;
            font-size: 11px;
        }
        .copyright {
            text-align: center;
            color: #999999;
            font-size: 8px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 50px; text-align: center; vertical-align: middle;">
                <span class="logo-cross">✝</span>
            </td>
            <td>
                <div class="church-title">{{ $settings['nama_gereja'] }}</div>
                <div class="church-sub">{{ $settings['alamat_gereja'] ?: 'Portal Pelayanan Jemaat' }}</div>
            </td>
            <td style="text-align: right; vertical-align: middle; color: #666666; font-size: 9px;">
                BUKTI RESMI DIGITAL
            </td>
        </tr>
    </table>

    <!-- Title -->
    <div class="title">TANDA TERIMA PERSEMBAHAN</div>

    <!-- Details Table -->
    <table class="details-table">
        <tr>
            <td class="label">No. Transaksi (Order ID)</td>
            <td class="value">: <strong>{{ $persembahan->order_id }}</strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal Pembayaran</td>
            <td class="value">: {{ $persembahan->paid_at ? $persembahan->paid_at->format('d F Y H:i') : now()->format('d F Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Nama Donatur</td>
            <td class="value">: {{ $persembahan->nama_lengkap_donatur }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Persembahan</td>
            <td class="value">: {{ $persembahan->jenisPersembahan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Metode Pembayaran</td>
            <td class="value" style="text-transform: uppercase;">: {{ str_replace('_', ' ', $persembahan->metode_bayar ?: 'Midtrans Gateway') }}</td>
        </tr>
        @if($persembahan->keterangan)
        <tr>
            <td class="label">Keterangan / Pokok Doa</td>
            <td class="value">: {{ $persembahan->keterangan }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Jumlah Nominal</td>
            <td class="value-bold">: Rp {{ number_format($persembahan->nominal, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Footer Area with QR Code -->
    <table class="footer-table">
        <tr>
            <td style="text-align: center; vertical-align: middle; width: 65%;">
                <div class="thank-you">
                    "Tuhan memberkati pelayanan dan persembahan syukur Anda."
                </div>
                <div class="copyright">
                    Tanda terima ini sah dikeluarkan secara elektronik oleh sistem portal jemaat {{ $settings['nama_gereja'] }}.
                </div>
            </td>
            <td style="text-align: center; vertical-align: middle; width: 35%;">
                <img src="data:image/png;base64,{{ $qrBase64 }}" width="90" alt="QR Code Verifikasi"><br>
                <span style="font-size: 8px; color: #999999; margin-top: 5px; display: block;">Pindai untuk verifikasi</span>
            </td>
        </tr>
    </table>

</body>
</html>
