<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil – GEMINDO Kawan Kasih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-gemindo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-gemindo.png') }}">
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
            max-width: 540px;
            width: 100%;
            padding: 50px 40px;
            text-align: center;
            position: relative;
        }

        /* Ornamental corner boundary */
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
            width: 50px;
            height: 66px;
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
            margin-bottom: 12px;
        }

        /* Ornamental Gold Divider */
        .success-divider {
            display: flex; align-items: center; gap: 12px;
            justify-content: center; margin-bottom: 24px;
        }
        .success-divider::before, .success-divider::after {
            content: ''; flex: 1; max-width: 80px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-warm));
        }
        .success-divider::after { background: linear-gradient(270deg, transparent, var(--border-warm)); }
        .success-divider span {
            font-size: 10px; color: var(--gold-dark);
            font-family: 'Cinzel', serif; letter-spacing: 0.15em;
        }

        .success-desc {
            font-family: 'Inter', sans-serif;
            font-size: 14.5px;
            color: var(--text-dark);
            margin-bottom: 30px;
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }

        /* Scripture Quote block */
        .scripture-box {
            font-family: 'EB Garamond', serif;
            font-style: italic;
            color: var(--text-mid);
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 36px;
            padding: 0 16px;
            position: relative;
            z-index: 2;
        }
        .scripture-ref {
            font-family: 'Cinzel', serif;
            font-size: 11px;
            font-style: normal;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--gold-dark);
            display: block;
            margin-top: 6px;
        }

        /* Buttons Group */
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
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.05em;
            text-transform: uppercase;
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
            .success-card { padding: 36px 22px 36px; }
            .success-title { font-size: 20px; }
        }
        @media (max-width: 400px) {
            body { padding: 14px; }
            .success-card { padding: 26px 16px 28px; }
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="cross-emblem"></div>
        
        <h1 class="success-title">Pendaftaran Berhasil!</h1>
        
        <div class="success-divider">
            <span>TERIMA KASIH</span>
        </div>

        <p class="success-desc">
            Terima kasih telah mendaftar di GEMINDO Kawan Kasih. Formulir pendaftaran Anda telah dikirimkan ke pihak Majelis Jemaat. Kami akan memeriksa berkas Anda dan mengirimkan notifikasi persetujuan beserta akun akses portal resmi via email dalam 1-3 hari kerja.
        </p>

        <!-- Scripture Quote -->
        <div class="scripture-box">
            "Bersyukurlah kepada TUHAN, sebab Ia baik! Bahwasanya untuk selama-lamanya kasih setia-Nya."
            <span class="scripture-ref">1 Tawarikh 16:34</span>
        </div>

        <div class="btn-group">
            <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
            <a href="{{ route('persembahan.index') }}" class="btn btn-outline">Menuju Persembahan Online</a>
        </div>
    </div>

</body>
</html>
