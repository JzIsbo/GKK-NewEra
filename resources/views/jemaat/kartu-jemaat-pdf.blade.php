<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Anggota Jemaat - {{ $user->nomor_jemaat }}</title>
    <style>
        @page {
            margin: 0px;
        }
        * {
            margin: 0;
            padding: 0;
        }
        html, body {
            margin: 0px;
            padding: 0px;
            background-color: #0b1325;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #ffffff;
            -webkit-print-color-adjust: exact;
        }

        .card {
            width: 235pt;
            height: 139pt;
            background-color: #0b1325;
            border: 3pt solid #c8941a;
            padding: 5pt 7pt;
            position: relative;
        }

        /* Inner gold hairline border */
        .inner-border {
            position: absolute;
            top: 2pt;
            left: 2pt;
            right: 2pt;
            bottom: 2pt;
            border: 0.5pt solid rgba(200, 148, 26, 0.35);
        }

        /* Cross watermark in background */
        .bg-cross {
            position: absolute;
            right: -6pt;
            bottom: -10pt;
            width: 50pt;
            height: 80pt;
            opacity: 0.04;
        }
        .bg-cross-v {
            position: absolute;
            left: 22pt;
            top: 0;
            width: 6pt;
            height: 100%;
            background-color: #ffffff;
        }
        .bg-cross-h {
            position: absolute;
            left: 0;
            top: 25pt;
            width: 100%;
            height: 6pt;
            background-color: #ffffff;
        }

        /* Header layout */
        .header-table {
            width: 100%;
            border-bottom: 0.75pt solid rgba(200, 148, 26, 0.4);
            padding-bottom: 3pt;
            margin-bottom: 4pt;
        }
        .cross-icon {
            position: relative;
            width: 12pt;
            height: 16pt;
        }
        .cross-v {
            position: absolute;
            left: 5pt;
            top: 0;
            width: 2pt;
            height: 100%;
            background-color: #c8941a;
        }
        .cross-h {
            position: absolute;
            left: 0;
            top: 5pt;
            width: 100%;
            height: 2pt;
            background-color: #c8941a;
        }
        .church-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #ffffff;
            font-family: Georgia, serif;
            letter-spacing: 0.5pt;
            line-height: 1.1;
        }
        .sub-title {
            font-size: 4.8pt;
            color: #e8b84b;
            font-weight: bold;
            letter-spacing: 0.8pt;
            text-transform: uppercase;
        }

        /* Main layout table */
        .main-table {
            width: 100%;
        }

        .lbl {
            font-size: 4.6pt;
            color: #7d97be;
            text-transform: uppercase;
            letter-spacing: 0.4pt;
            margin-bottom: 1pt;
        }
        .nij-value {
            font-size: 11pt;
            font-weight: bold;
            color: #e8b84b;
            letter-spacing: 0.5pt;
            line-height: 1;
            margin-bottom: 3pt;
        }
        .name-value {
            font-size: 7.5pt;
            font-weight: bold;
            color: #ffffff;
            line-height: 1.15;
            margin-bottom: 4pt;
            text-transform: uppercase;
        }
        .val {
            font-size: 5.8pt;
            font-weight: bold;
            color: #ffffff;
        }
        .val-active {
            font-size: 5.8pt;
            font-weight: bold;
            color: #2ed573;
        }

        /* Right column: Photo and QR code */
        .photo-box {
            width: 36pt;
            height: 44pt;
            border: 1pt solid #c8941a;
            background-color: #152037;
            text-align: center;
        }
        .photo-box-text {
            font-size: 5pt;
            color: rgba(255, 255, 255, 0.4);
            font-weight: bold;
            line-height: 44pt;
            letter-spacing: 0.5pt;
        }
        .qr-box {
            width: 36pt;
            height: 36pt;
            border: 1pt solid #c8941a;
            background-color: #ffffff;
            margin-top: 3pt;
        }

        .validity-text {
            font-size: 4pt;
            color: #7d97be;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
            text-align: right;
            margin-top: 2pt;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="inner-border"></div>

        <!-- Watermark Background Cross -->
        <div class="bg-cross">
            <div class="bg-cross-v"></div>
            <div class="bg-cross-h"></div>
        </div>

        <!-- Header -->
        <table class="header-table" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 16pt; vertical-align: middle;">
                    <div class="cross-icon">
                        <div class="cross-v"></div>
                        <div class="cross-h"></div>
                    </div>
                </td>
                <td style="vertical-align: middle;">
                    <div class="church-title">{{ strtoupper($settings['nama_gereja'] ?? 'GEMINDO KAWAN KASIH') }}</div>
                    <div class="sub-title">KARTU ANGGOTA JEMAAT</div>
                </td>
            </tr>
        </table>

        <!-- Main Body Details -->
        <table class="main-table" cellpadding="0" cellspacing="0">
            <tr>
                <!-- Left Details -->
                <td style="width: 152pt; vertical-align: top; padding-right: 5pt;">
                    <div class="lbl">Nomor Induk Jemaat</div>
                    <div class="nij-value">{{ $user->nomor_jemaat ?: 'BELUM AKTIF' }}</div>

                    <div class="lbl">Nama Lengkap</div>
                    <div class="name-value">{{ $user->nama_lengkap ?: $user->name }}</div>

                    <table style="width: 100%; margin-top: 2pt;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                                <div class="lbl">Kategori KPK</div>
                                <div class="val">{{ $user->kategori->nama ?? 'Umum' }}</div>
                            </td>
                            <td style="width: 50%; vertical-align: top;">
                                <div class="lbl">Status</div>
                                <div class="val-active">&#9679; AKTIF</div>
                            </td>
                        </tr>
                    </table>

                    @if(!empty($user->jenis_kelamin) || !empty($user->tanggal_lahir))
                    <table style="width: 100%; margin-top: 3pt;" cellpadding="0" cellspacing="0">
                        <tr>
                            @if(!empty($user->jenis_kelamin))
                            <td style="width: 50%; vertical-align: top;">
                                <div class="lbl">Gender</div>
                                <div class="val">{{ ucfirst($user->jenis_kelamin) }}</div>
                            </td>
                            @endif
                            @if(!empty($user->tanggal_lahir))
                            <td style="width: 50%; vertical-align: top;">
                                <div class="lbl">Tgl. Lahir</div>
                                <div class="val">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d/m/Y') }}</div>
                            </td>
                            @endif
                        </tr>
                    </table>
                    @endif
                </td>

                <!-- Right Photo & QR Code -->
                <td style="width: 44pt; text-align: right; vertical-align: top;">
                    <table align="right" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align: right;">
                                <!-- Photo Box -->
                                @if(!empty($user->foto) && file_exists(public_path('storage/' . $user->foto)))
                                    <img src="{{ public_path('storage/' . $user->foto) }}" width="48" height="58" style="object-fit: cover; border: 1pt solid #c8941a; display: block;">
                                @else
                                    <div class="photo-box">
                                        <div class="photo-box-text">FOTO</div>
                                    </div>
                                @endif

                                <!-- QR Code Box -->
                                @if(!empty($qrBase64))
                                    <img src="data:image/png;base64,{{ $qrBase64 }}" width="48" height="48" style="background-color: #ffffff; padding: 2px; border: 1pt solid #c8941a; display: block; margin-top: 3pt;">
                                @else
                                    <div class="qr-box" style="text-align: center; background-color: #152037;">
                                        <div style="font-size: 5pt; color: rgba(255,255,255,0.4); line-height: 36pt; font-weight: bold;">QR</div>
                                    </div>
                                @endif

                                <div class="validity-text">
                                    Masa Berlaku: Seumur Hidup
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
