<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persembahan Berhasil – GEMINDO Kawan Kasih</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --mahogany:      #2c1810;
            --mahogany-mid:  #3d2317;
            --mahogany-dark: #1a0e09;
            --gold:          #c8941a;
            --gold-light:    #e8b84b;
            --gold-pale:     #f5e1a0;
            --gold-dark:     #9a7012;
            --burgundy:      #6b1a2e;
            --parchment:     #fdf6e3;
            --cream:         #faf0d7;
            --ivory:         #fffcf5;
            --text-dark:     #2c1810;
            --text-mid:      #5a3a1a;
            --text-muted:    #8a6a42;
            --border-warm:   #e8d5aa;
            --success:       #2a7a44;
            --radius:        12px;
            --transition:    all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background: var(--parchment);
            /* Candlelight glow background */
            background-image: 
                radial-gradient(ellipse 60% 40% at 50% 0%, rgba(200, 148, 26, 0.08) 0%, transparent 70%),
                radial-gradient(ellipse 50% 50% at 50% 100%, rgba(107, 26, 46, 0.04) 0%, transparent 70%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            line-height: 1.7;
        }

        .success-card {
            background-color: var(--ivory);
            border-radius: var(--radius);
            border: 1px solid var(--border-warm);
            box-shadow: 
                0 15px 40px rgba(44, 24, 16, 0.06),
                0 1px 3px rgba(200, 148, 26, 0.1),
                inset 0 0 40px rgba(250, 240, 215, 0.4);
            max-width: 560px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }

        /* Inner corner border */
        .success-card::before {
            content: ''; position: absolute;
            top: 12px; left: 12px; right: 12px; bottom: 12px;
            border: 1px solid rgba(200, 148, 26, 0.15);
            border-radius: calc(var(--radius) - 4px);
            pointer-events: none;
        }

        /* Success Cross Emblem */
        .cross-emblem {
            position: relative;
            width: 44px;
            height: 58px;
            margin: 0 auto 24px;
        }
        .cross-emblem::before {
            content: ''; position: absolute;
            left: 50%; top: 0; transform: translateX(-50%);
            width: 8px; height: 100%;
            background: linear-gradient(180deg, var(--gold-light), var(--gold-dark));
            border-radius: 4px;
            box-shadow: 0 0 12px rgba(200, 148, 26, 0.6);
        }
        .cross-emblem::after {
            content: ''; position: absolute;
            left: 0; top: 35%;
            width: 100%; height: 8px;
            background: linear-gradient(90deg, var(--gold-light), var(--gold-dark));
            border-radius: 4px;
            box-shadow: 0 0 12px rgba(200, 148, 26, 0.6);
        }

        .success-title {
            font-family: 'Cinzel Decorative', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--mahogany);
            margin-bottom: 6px;
        }

        .success-subtitle {
            font-family: 'EB Garamond', serif;
            font-size: 16px;
            color: var(--text-mid);
            margin-bottom: 28px;
            font-style: italic;
        }

        /* ═══════════════════════════════════════
           DETAILS BOX (Parchment Bulletin Table)
           ═══════════════════════════════════════ */
        .details-box {
            background-color: var(--cream);
            border: 1px solid var(--border-warm);
            border-radius: 8px;
            padding: 22px 24px;
            text-align: left;
            margin-bottom: 28px;
            position: relative;
            z-index: 2;
        }
        .details-title {
            font-family: 'Cinzel', serif;
            font-size: 13px;
            font-weight: 700;
            color: var(--mahogany);
            margin-bottom: 14px;
            border-bottom: 1.5px solid var(--border-warm);
            padding-bottom: 8px;
            letter-spacing: 0.05em;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            font-size: 13.5px;
            margin-bottom: 10px;
        }
        .details-row:last-child {
            margin-bottom: 0;
            font-weight: 700;
            border-top: 1px dashed var(--border-warm);
            padding-top: 10px;
            margin-top: 10px;
        }
        .details-label {
            color: var(--text-muted);
        }
        .details-value {
            color: var(--text-dark);
            text-align: right;
            font-family: 'Inter', sans-serif;
        }

        /* Verse block */
        .verse-box {
            font-family: 'EB Garamond', serif;
            font-style: italic;
            color: var(--text-mid);
            font-size: 16.5px;
            line-height: 1.6;
            margin-bottom: 32px;
            padding: 0 16px;
            position: relative;
            z-index: 2;
        }
        .verse-ref {
            font-family: 'Cinzel', serif;
            font-size: 11px;
            font-style: normal;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--gold-dark);
            display: block;
            margin-top: 6px;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 2;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 13px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            width: 100%;
            border: none;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            box-shadow: 0 4px 14px rgba(200, 148, 26, 0.35);
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(200, 148, 26, 0.5);
            transform: translateY(-1px);
        }
        
        .btn-accent {
            background-color: var(--mahogany);
            color: var(--gold-light);
            border: 1px solid var(--gold);
            box-shadow: 0 4px 14px rgba(44, 24, 16, 0.2);
        }
        .btn-accent:hover {
            background-color: var(--mahogany-mid);
            box-shadow: 0 6px 20px rgba(44, 24, 16, 0.3);
            transform: translateY(-1px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1.5px solid var(--border-warm);
            color: var(--text-mid);
        }
        .btn-outline:hover {
            border-color: var(--mahogany);
            color: var(--mahogany);
            background-color: rgba(200, 148, 26, 0.05);
        }

        /* MOBILE */
        @media (max-width: 600px) {
            body { padding: 18px; align-items: flex-start; }
            .success-card { padding: 32px 22px 36px; }
            .success-title { font-size: 20px; }
        }
        @media (max-width: 400px) {
            body { padding: 14px; }
            .success-card { padding: 26px 16px 28px; }
            .success-title { font-size: 18px; }
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="cross-emblem"></div>
        
        <h1 class="success-title">Persembahan Diterima!</h1>
        <p class="success-subtitle">Terima kasih atas persembahan syukur yang telah Anda salurkan.</p>

        <!-- Details -->
        <div class="details-box">
            <div class="details-title">Rincian Transaksi</div>
            <div class="details-row">
                <div class="details-label">ID Transaksi</div>
                <div class="details-value" style="font-weight: 600;">{{ $persembahan->order_id }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Nama Donatur</div>
                <div class="details-value">{{ $persembahan->nama_lengkap_donatur }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Jenis Persembahan</div>
                <div class="details-value">{{ $persembahan->jenisPersembahan->nama ?? '-' }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Metode Pembayaran</div>
                <div class="details-value" style="text-transform: uppercase;">{{ str_replace('_', ' ', $persembahan->metode_bayar ?: '-') }}</div>
            </div>
            <div class="details-row">
                <div class="details-label">Tanggal Bayar</div>
                <div class="details-value">{{ $persembahan->paid_at ? $persembahan->paid_at->translatedFormat('d F Y H:i') : now()->translatedFormat('d F Y H:i') }} WIB</div>
            </div>
            <div class="details-row">
                <div class="details-label">Jumlah Persembahan</div>
                <div class="details-value" style="font-weight: 700; color: var(--success);">Rp {{ number_format($persembahan->nominal, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Verse -->
        <div class="verse-box">
            "Hendaklah masing-masing memberikan menurut kerelaan hatinya, jangan dengan sedih hati atau karena paksaan, sebab Allah mengasihi orang yang memberi dengan sukacita."
            <span class="verse-ref">2 Korintus 9:7</span>
        </div>

        <!-- Buttons -->
        <div class="btn-group">
            <a href="{{ route('persembahan.bukti', $persembahan->order_id) }}" class="btn btn-accent">📥 Unduh Bukti PDF</a>
            <a href="{{ route('persembahan.index') }}" class="btn btn-primary">💸 Beri Persembahan Lagi</a>
            <a href="{{ route('home') }}" class="btn btn-outline">← Kembali ke Halaman Utama</a>
        </div>
    </div>

</body>
</html>
