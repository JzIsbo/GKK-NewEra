<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Anggota Jemaat - {{ $user->nomor_jemaat }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0d1527;
            color: #ffffff;
            -webkit-print-color-adjust: exact;
        }
        .card-container {
            width: 100%;
            height: 100%;
            position: relative;
            background-color: #0d1527;
            border: 4px solid #c8941a;
            padding: 10px 12px;
            box-sizing: border-box;
        }
        /* Inner decorative gold border */
        .inner-border {
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border: 1px solid rgba(200, 148, 26, 0.25);
            pointer-events: none;
        }
        /* CSS background cross watermark to replace UTF-8 symbol */
        .bg-cross {
            position: absolute;
            right: 18px;
            bottom: -5px;
            width: 44px;
            height: 76px;
            opacity: 0.04;
            pointer-events: none;
        }
        .bg-cross-v {
            position: absolute;
            left: 19px;
            top: 0;
            width: 6px;
            height: 100%;
            background-color: #ffffff;
        }
        .bg-cross-h {
            position: absolute;
            left: 0;
            top: 24px;
            width: 100%;
            height: 6px;
            background-color: #ffffff;
        }

        /* Header logo */
        .header-table {
            width: 100%;
            border-bottom: 1px solid rgba(200, 148, 26, 0.3);
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        .logo-cross-wrapper {
            position: relative;
            width: 14px;
            height: 18px;
            display: inline-block;
        }
        .logo-cross-v {
            position: absolute;
            left: 6px;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: #c8941a;
        }
        .logo-cross-h {
            position: absolute;
            left: 0;
            top: 5px;
            width: 100%;
            height: 2px;
            background-color: #c8941a;
        }

        .church-title {
            font-family: Georgia, serif;
            font-size: 9px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        .sub-title {
            font-size: 5.5px;
            color: #e8b84b;
            font-weight: bold;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Card Content Layout */
        .content-table {
            width: 100%;
        }
        .label {
            color: #8a9fc4;
            font-size: 5.5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .value {
            font-size: 8px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 3px;
        }
        .nij-value {
            font-size: 10px;
            font-weight: bold;
            color: #e8b84b;
            margin-bottom: 3px;
        }

        /* Photo placeholder */
        .photo-box {
            width: 44px;
            height: 52px;
            border: 1px solid #c8941a;
            background-color: #17223b;
            position: relative;
            text-align: center;
        }
        .photo-placeholder-text {
            font-size: 5px;
            color: rgba(255, 255, 255, 0.4);
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            letter-spacing: 0.2px;
        }
    </style>
</head>
<body>

    <div class="card-container">
        <!-- Inner Border Line -->
        <div class="inner-border"></div>

        <!-- Cross Watermark Background -->
        <div class="bg-cross">
            <div class="bg-cross-v"></div>
            <div class="bg-cross-h"></div>
        </div>
        
        <!-- Header logo -->
        <table class="header-table" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 20px; vertical-align: middle;">
                    <div class="logo-cross-wrapper">
                        <div class="logo-cross-v"></div>
                        <div class="logo-cross-h"></div>
                    </div>
                </td>
                <td style="vertical-align: middle;">
                    <div class="church-title">{{ $settings['nama_gereja'] }}</div>
                    <div class="sub-title">KARTU ANGGOTA JEMAAT</div>
                </td>
            </tr>
        </table>

        <!-- Details split -->
        <table class="content-table" cellpadding="0" cellspacing="0">
            <tr>
                <!-- Left Column: Details -->
                <td style="width: 62%; vertical-align: top;">
                    <div class="label">Nomor Induk Jemaat</div>
                    <div class="nij-value">{{ $user->nomor_jemaat ?: 'BELUM AKTIF' }}</div>

                    <div class="label">Nama Lengkap</div>
                    <div class="value" style="font-size: 8.5px;">{{ strtoupper($user->nama_lengkap ?: $user->name) }}</div>

                    <table style="width: 100%; margin-top: 1px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                                <div class="label">Kategori KPK</div>
                                <div class="value" style="font-size: 7px;">{{ $user->kategori->nama ?? 'Umum' }}</div>
                            </td>
                            <td style="width: 50%; vertical-align: top;">
                                <div class="label">Status</div>
                                <div class="value" style="font-size: 7px; color: #2a7a44;">AKTIF</div>
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- Right Column: Photo & QR Code -->
                <td style="width: 38%; text-align: right; vertical-align: top;">
                    <table align="right" cellpadding="0" cellspacing="0">
                        <tr>
                            <!-- Photo Box -->
                            <td style="vertical-align: top; padding-right: 6px;">
                                @if($user->foto)
                                    <img src="{{ public_path('storage/' . $user->foto) }}" width="44" height="52" style="object-fit: cover; border: 1px solid #c8941a; display: block;">
                                @else
                                    <div class="photo-box">
                                        <div class="photo-placeholder-text">FOTO</div>
                                    </div>
                                @endif
                            </td>
                            <!-- QR Code Box -->
                            <td style="vertical-align: top; width: 44px;">
                                @if($qrBase64)
                                    <img src="data:image/png;base64,{{ $qrBase64 }}" width="44" height="44" style="background-color: #ffffff; padding: 2px; border: 1px solid #c8941a; display: block;">
                                @else
                                    <div style="width: 44px; height: 44px; background-color: #17223b; border: 1px solid #c8941a; position: relative;">
                                        <div style="font-size: 4px; color: rgba(255,255,255,0.4); text-align: center; margin-top: 18px; font-weight: bold;">QR</div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div style="font-size: 4.5px; color: #8a9fc4; margin-top: 55px; text-align: right; text-transform: uppercase; letter-spacing: 0.2px;">
                        Masa Berlaku: Seumur Hidup
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
