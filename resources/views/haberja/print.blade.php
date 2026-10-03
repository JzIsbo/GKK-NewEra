<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan RAB &amp; Struktur Panitia HABERJA 2026 – GEMINDO Kawan Kasih</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #1a0e09;
            background: #fff;
            margin: 0;
            padding: 24px 32px;
            font-size: 11pt;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #2c1810;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 13pt;
            margin: 0 0 4px 0;
            font-weight: 600;
        }
        .header p {
            font-size: 10pt;
            margin: 0;
            font-style: italic;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin-top: 24px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            font-size: 10pt;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px 8px;
            text-align: left;
        }
        th {
            background-color: #f2ede4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row {
            font-weight: bold;
            background-color: #f9f6f0;
        }
        .signatures {
            margin-top: 36px;
            width: 100%;
            border: none;
        }
        .signatures td {
            border: none;
            padding: 0;
            text-align: center;
            vertical-align: top;
            width: 33.33%;
        }
        .no-print {
            margin-bottom: 20px;
            padding: 10px;
            background: #fdf6e3;
            border: 1px solid #c8941a;
            border-radius: 6px;
            text-align: center;
        }
        .btn-print {
            background: #2c1810;
            color: #fff;
            border: none;
            padding: 8px 18px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10.5pt;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen / Simpan PDF</button>
    <a href="{{ route('haberja.index') }}" style="margin-left: 12px; color: #2c1810; text-decoration: underline; font-size: 10pt;">Kembali ke Dashboard HABERJA</a>
</div>

<div class="header">
    <h1>GEREJA MASEHI INJILI DI INDONESIA (GEMINDO)</h1>
    <h2>JEMAAT KAWAN KASIH</h2>
    <p>Sekretariat: Jl. Kasih Persaudaraan No. 12 &bull; Pelayanan Hari-Hari Besar Gereja (HABERJA) Tahun 2026</p>
</div>

<div class="text-center" style="margin-bottom: 20px;">
    <h3 style="margin: 0; font-size: 13pt; text-transform: uppercase;">
        @if($currentEvent)
            LAPORAN KEPANITIAAN &amp; RENCANA ANGGARAN BIAYA (RAB)<br>{{ strtoupper($currentEvent->nama) }}
        @else
            LAPORAN KONSOLIDASI KEPANITIAAN, PLANNING USAHA DANA<br>&amp; RENCANA ANGGARAN BIAYA (RAB) HABERJA 2026
        @endif
    </h3>
    <p style="margin: 4px 0 0 0; font-size: 10pt;">Periode Tahun Pelayanan 2026 / 2027</p>
</div>

<!-- 1. AGENDA HARI BESAR GEREJA -->
<div class="section-title">I. AGENDA HARI BESAR GEREJA (HABERJA 2026)</div>
<table>
    <thead>
        <tr>
            <th style="width: 30px;" class="text-center">No</th>
            <th>Acara Hari Besar</th>
            <th>Tema &amp; Nats Alkitab</th>
            <th style="width: 130px;">Jadwal Pelaksanaan</th>
            <th style="width: 120px;" class="text-right">Target Anggaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $idx => $ev)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>{{ $ev->nama }}</strong></td>
                <td><em>"{{ $ev->tema }}"</em> ({{ $ev->ayat_tema }})</td>
                <td>{{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                <td class="text-right">Rp {{ number_format($ev->target_anggaran, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="4" class="text-right">TOTAL ESTIMASI KEBUTUHAN HABERJA:</td>
            <td class="text-right">Rp {{ number_format($events->sum('target_anggaran'), 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<!-- 2. STRUKTUR PANITIA HABERJA -->
<div class="section-title">II. SUSUNAN STRUKTUR PANITIA HABERJA</div>
<table>
    <thead>
        <tr>
            <th style="width: 30px;" class="text-center">No</th>
            <th style="width: 170px;">Seksi / Bidang</th>
            <th style="width: 170px;">Jabatan</th>
            <th>Nama Personil</th>
            <th style="width: 110px;">Kontak</th>
        </tr>
    </thead>
    <tbody>
        @foreach($panitias as $idx => $p)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $p->seksi }}</td>
                <td><strong>{{ $p->jabatan }}</strong></td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->telepon ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- 3. PLANNING PENCARIAN DANA -->
<div class="section-title">III. PROGRAM KERJA PENCARIAN DANA</div>
<table>
    <thead>
        <tr>
            <th style="width: 30px;" class="text-center">No</th>
            <th>Program Usaha Dana</th>
            <th style="width: 110px;" class="text-right">Target Dana</th>
            <th style="width: 110px;" class="text-right">Realisasi</th>
            <th style="width: 130px;">PIC (Penanggung Jawab)</th>
            <th style="width: 80px;" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($danaPlans as $idx => $dp)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>
                    <strong>{{ $dp->nama_program }}</strong>
                    <div style="font-size: 8.5pt; color: #555;">{{ $dp->deskripsi }}</div>
                </td>
                <td class="text-right">Rp {{ number_format($dp->target_dana, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($dp->realisasi_dana, 0, ',', '.') }}</td>
                <td>{{ $dp->penanggung_jawab ?? '-' }}</td>
                <td class="text-center">{{ ucfirst($dp->status) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="2" class="text-right">TOTAL TARGET &amp; REALISASI DANA:</td>
            <td class="text-right">Rp {{ number_format($danaPlans->sum('target_dana'), 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($danaPlans->sum('realisasi_dana'), 0, ',', '.') }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

<!-- 4. RENCANA ANGGARAN BIAYA (RAB) -->
<div class="section-title">IV. RENCANA ANGGARAN BIAYA (RAB) PENGELUARAN</div>
<table>
    <thead>
        <tr>
            <th style="width: 30px;" class="text-center">No</th>
            <th style="width: 140px;">Pos Seksi</th>
            <th>Uraian Kebutuhan Belanja</th>
            <th style="width: 80px;" class="text-center">Volume</th>
            <th style="width: 90px;" class="text-right">Harga Satuan</th>
            <th style="width: 110px;" class="text-right">Total Anggaran</th>
            <th style="width: 110px;" class="text-right">Realisasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengeluarans as $idx => $bg)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $bg->seksi }}</td>
                <td>{{ $bg->uraian }}</td>
                <td class="text-center">{{ $bg->volume ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($bg->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($bg->total_anggaran, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($bg->realisasi, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="5" class="text-right">TOTAL KEBUTUHAN PENGELUARAN:</td>
            <td class="text-right">Rp {{ number_format($pengeluarans->sum('total_anggaran'), 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($pengeluarans->sum('realisasi'), 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<!-- 5. RENCANA SUMBER PEMASUKAN -->
<div class="section-title">V. RENCANA SUMBER PENERIMAAN / PEMASUKAN</div>
<table>
    <thead>
        <tr>
            <th style="width: 30px;" class="text-center">No</th>
            <th style="width: 160px;">Kategori Sumber</th>
            <th>Uraian Sumber Dana</th>
            <th style="width: 120px;" class="text-right">Target Masuk</th>
            <th style="width: 120px;" class="text-right">Realisasi Masuk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pemasukans as $idx => $pm)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>{{ $pm->seksi }}</strong></td>
                <td>{{ $pm->uraian }}</td>
                <td class="text-right">Rp {{ number_format($pm->total_anggaran, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($pm->realisasi, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="3" class="text-right">TOTAL ESTIMASI PENERIMAAN:</td>
            <td class="text-right">Rp {{ number_format($pemasukans->sum('total_anggaran'), 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($pemasukans->sum('realisasi'), 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<!-- TANDA TANGAN / PENGESAHAN -->
<table class="signatures">
    <tr>
        <td>
            Dibuat oleh,<br>
            <strong>Sekretaris Panitia HABERJA</strong><br><br><br><br><br>
            <u>Andreas Kevin Pasaribu</u>
        </td>
        <td>
            Mengetahui &amp; Memeriksa,<br>
            <strong>Bendahara Panitia HABERJA</strong><br><br><br><br><br>
            <u>Ruth Damayanti Situmorang, S.E.</u>
        </td>
        <td>
            Disetujui oleh,<br>
            <strong>Ketua Panitia HABERJA</strong><br><br><br><br><br>
            <u>Daniel Sihombing, S.T.</u>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 28px;">
            Mengetahui &amp; Mengesahkan:<br>
            <strong>Majelis Jemaat GEMINDO Kawan Kasih</strong>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 10px;">
            <strong>Ketua Majelis Jemaat</strong><br><br><br><br><br>
            <u>Pnt. Johanis Tarigan</u>
        </td>
        <td style="padding-top: 10px;"></td>
        <td style="padding-top: 10px;">
            <strong>Pendeta Jemaat</strong><br><br><br><br><br>
            <u>Pdt. Samuel Marbun, M.Th</u>
        </td>
    </tr>
</table>

</body>
</html>
