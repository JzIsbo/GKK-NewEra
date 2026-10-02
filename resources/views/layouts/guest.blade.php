<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') – GEMINDO Kawan Kasih</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:       #2c1810;
            --primary-light: #3d2317;
            --accent:        #c8941a;
            --accent-light:  #e8b84b;
            --accent-dark:   #a07614;
            --burgundy:      #6b1a2e;
            --danger:        #8b1a1a;
            --success:       #2d6a4f;
            --border:        #e8d9c0;
            --text:          #2c1810;
            --text-muted:    #7a5c42;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            padding: 20px; position: relative; overflow: hidden;
            /* Rich dark spiritual background */
            background: linear-gradient(145deg, #1a0e09 0%, #2c1810 35%, #3d1a10 65%, #1a1020 100%);
        }

        /* Animated radial glow — like candlelight */
        body::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 25% 60%, rgba(200,148,26,.10) 0%, transparent 70%),
                radial-gradient(ellipse 40% 60% at 80% 30%, rgba(107,26,46,.08) 0%, transparent 60%),
                radial-gradient(ellipse 30% 40% at 50% 90%, rgba(200,148,26,.06) 0%, transparent 60%);
            animation: breathe 8s ease-in-out infinite;
        }
        @keyframes breathe {
            0%, 100% { opacity: 1; }
            50% { opacity: .6; }
        }

        /* Subtle cross lattice overlay */
        body::after {
            content: ''; position: absolute; inset: 0; opacity: .025;
            background-image:
                linear-gradient(rgba(200,148,26,1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(200,148,26,1) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Large decorative cross */
        .bg-cross {
            position: fixed; right: -80px; bottom: -60px;
            font-size: 400px; color: rgba(200,148,26,.03);
            font-family: 'Cinzel', serif; line-height: 1;
            pointer-events: none; user-select: none;
        }

        .guest-container {
            position: relative; z-index: 1;
            width: 100%; max-width: 460px;
        }

        /* Logo & church name */
        .guest-logo {
            text-align: center; margin-bottom: 28px;
        }
        .cross-emblem {
            display: inline-flex; align-items: center; justify-content: center;
            width: 70px; height: 70px; margin-bottom: 16px;
            position: relative;
        }
        .cross-emblem::before {
            content: ''; position: absolute;
            left: 50%; top: 0; transform: translateX(-50%);
            width: 10px; height: 100%;
            background: linear-gradient(180deg, var(--accent-light), var(--accent-dark));
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(200,148,26,.5);
        }
        .cross-emblem::after {
            content: ''; position: absolute;
            left: 0; top: 28%;
            width: 100%; height: 10px;
            background: linear-gradient(90deg, var(--accent-light), var(--accent-dark));
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(200,148,26,.5);
        }
        .logo-church-name {
            font-family: 'Cinzel', serif;
            font-size: 20px; font-weight: 700; color: #fff;
            letter-spacing: .06em; margin-bottom: 4px;
        }
        .logo-sub {
            font-family: 'EB Garamond', serif;
            font-size: 14px; color: rgba(200,148,26,.7);
            letter-spacing: .1em; font-style: italic;
        }
        .logo-verse {
            font-family: 'EB Garamond', serif;
            font-size: 13px; color: rgba(255,255,255,.35);
            font-style: italic; margin-top: 8px; line-height: 1.5;
        }

        /* Card */
        .guest-card {
            background: linear-gradient(145deg, #fffcf5 0%, #fdf6e3 100%);
            border-radius: 18px;
            box-shadow:
                0 25px 60px rgba(0,0,0,.4),
                0 0 0 1px rgba(200,148,26,.15),
                inset 0 1px 0 rgba(255,255,255,.9);
            padding: 36px 38px;
            position: relative; overflow: hidden;
        }
        /* Gold top border accent */
        .guest-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
        }
        /* Subtle corner ornament */
        .guest-card::after {
            content: '✦'; position: absolute;
            bottom: 16px; right: 20px;
            font-size: 40px; color: rgba(200,148,26,.06);
            font-family: 'Cinzel', serif;
        }

        .card-title {
            font-family: 'Cinzel', serif;
            font-size: 21px; font-weight: 700;
            color: var(--primary); margin-bottom: 5px; letter-spacing: .02em;
        }
        .card-sub {
            font-family: 'EB Garamond', serif;
            font-size: 15px; color: var(--text-muted);
            margin-bottom: 26px; line-height: 1.5;
        }

        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block; font-size: 12.5px;
            font-weight: 600; color: var(--text); margin-bottom: 6px;
            letter-spacing: .03em; text-transform: uppercase;
        }
        .form-control {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 9px; font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--text); background: #fffcf8;
            outline: none; transition: all .2s;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200,148,26,.14);
            background: #fff;
        }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: 12px; margin-top: 4px; }

        .btn-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #f5e8d0; border: none; border-radius: 9px;
            font-size: 15px; font-weight: 600;
            font-family: 'Cinzel', serif; cursor: pointer;
            transition: all .25s ease; margin-top: 8px;
            letter-spacing: .05em;
            box-shadow: 0 4px 14px rgba(44,24,16,.3);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            box-shadow: 0 6px 20px rgba(44,24,16,.4);
            transform: translateY(-1px);
        }

        .btn-gold {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--accent-light), var(--accent-dark));
            color: var(--primary); border: none; border-radius: 9px;
            font-size: 15px; font-weight: 700;
            font-family: 'Cinzel', serif; cursor: pointer;
            transition: all .25s ease; margin-top: 8px;
            letter-spacing: .05em;
            box-shadow: 0 4px 14px rgba(200,148,26,.35);
        }
        .btn-gold:hover {
            box-shadow: 0 6px 20px rgba(200,148,26,.5);
            transform: translateY(-1px);
        }

        .checkbox-group {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text-muted);
        }
        .checkbox-group input { width: 16px; height: 16px; cursor: pointer; accent-color: var(--accent-dark); }

        .alert { padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border-left: 4px solid; }
        .alert-danger  { background: #f8e8e8; border-color: var(--danger); color: #8b1a1a; }
        .alert-success { background: #e8f5ee; border-color: var(--success); color: #2d6a4f; }

        .text-link { color: var(--accent-dark); text-decoration: none; font-weight: 600; }
        .text-link:hover { text-decoration: underline; color: var(--primary); }

        .divider {
            text-align: center; font-size: 12px;
            color: var(--text-muted); margin: 22px 0; position: relative;
        }
        .divider::before {
            content: ''; position: absolute; top: 50%; left: 0; right: 0;
            height: 1px; background: var(--border);
        }
        .divider span { background: linear-gradient(135deg, #fffcf5, #fdf6e3); padding: 0 14px; position: relative; }

        .back-home {
            text-align: center; margin-top: 22px;
            font-size: 13px; color: rgba(255,255,255,.4);
        }
        .back-home a { color: rgba(200,148,26,.7); text-decoration: none; transition: color .2s; }
        .back-home a:hover { color: var(--accent-light); }

        /* ======= MOBILE ======= */
        @media (max-width: 520px) {
            body { padding: 16px; align-items: flex-start; }
            .guest-container { padding-top: 16px; }
            .guest-card { padding: 26px 22px 28px; border-radius: 14px; }
            .logo-church-name { font-size: 17px; }
            .card-title { font-size: 18px; }
            .btn-submit, .btn-gold { font-size: 14px; padding: 12px; }
        }
        @media (max-width: 380px) {
            body { padding: 12px; }
            .guest-card { padding: 22px 16px 24px; }
            .form-control { padding: 10px 12px; font-size: 14px; }
        }
        /* iPhone notch */
        @supports (padding-top: env(safe-area-inset-top)) {
            body { padding-top: calc(16px + env(safe-area-inset-top)); }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="bg-cross">✝</div>

    <div class="guest-container">
        <div class="guest-logo">
            <div class="cross-emblem"></div>
            <div class="logo-church-name">GEMINDO Kawan Kasih</div>
            <div class="logo-sub">Portal Jemaat</div>
            <div class="logo-verse">"Sebab di mana dua atau tiga orang berkumpul dalam nama-Ku, Aku hadir di tengah-tengah mereka." — Mat. 18:20</div>
        </div>

        <div class="guest-card">
            @yield('content')
        </div>

        <div class="back-home">
            <a href="{{ route('home') }}">← Kembali ke Halaman Utama</a>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
