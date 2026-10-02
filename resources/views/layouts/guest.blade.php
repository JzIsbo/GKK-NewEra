<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') – GEMINDO Kawan Kasih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-gemindo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('icons/icon-512x512.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="GEMINDO KK">
    <meta name="application-name" content="GEMINDO KK">
    <meta name="theme-color" content="#2c1810">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=EB+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 30px 16px 50px;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
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
            width: 100%; max-width: 480px;
            margin: auto 0;
        }

        /* Logo & church name */
        .guest-logo {
            text-align: center; margin-bottom: 24px;
        }
        .guest-logo-wrap {
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 14px; position: relative;
        }
        .guest-logo-wrap::before {
            content: ''; position: absolute; inset: -10px;
            background: radial-gradient(circle, rgba(200,148,26,.25) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .guest-logo-img {
            width: 78px; height: 92px; object-fit: contain; position: relative; z-index: 1;
            filter: drop-shadow(0 6px 18px rgba(0,0,0,.5)) drop-shadow(0 0 12px rgba(200,148,26,.35));
        }
        .logo-church-name {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 21px; font-weight: 800; color: #fff;
            letter-spacing: -0.01em; margin-bottom: 3px;
        }
        .logo-sub {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 11.5px; font-weight: 700; color: var(--accent-light);
            letter-spacing: .1em; text-transform: uppercase;
        }
        .logo-verse {
            font-family: 'EB Garamond', Georgia, serif;
            font-size: 13.5px; color: rgba(255,255,255,.55);
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
            padding: 32px 28px;
            position: relative;
        }
        /* Gold top border accent */
        .guest-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
            border-radius: 18px 18px 0 0;
        }
        /* Subtle corner ornament */
        .guest-card::after {
            content: '✦'; position: absolute;
            bottom: 16px; right: 20px;
            font-size: 40px; color: rgba(200,148,26,.06);
            font-family: sans-serif;
        }

        .card-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 22px; font-weight: 800;
            color: var(--primary); margin-bottom: 6px; letter-spacing: -0.015em;
        }
        .card-sub {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 13.5px; color: var(--text-muted);
            margin-bottom: 24px; line-height: 1.5;
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
            html, body { overflow-x: hidden !important; max-width: 100vw !important; }
            body { padding: 16px; align-items: flex-start; }
            .guest-container { padding-top: 16px; width: 100%; max-width: 100%; }
            .guest-card { padding: 26px 20px 28px; border-radius: 14px; width: 100%; max-width: 100%; box-sizing: border-box; overflow: hidden; }
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
            <div class="guest-logo-wrap">
                <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="guest-logo-img">
            </div>
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
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('[SW] Registered:', reg.scope))
                .catch(err => console.warn('[SW] Registration failed:', err));
        });
    }
    </script>
</body>
</html>
