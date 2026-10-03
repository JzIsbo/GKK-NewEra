<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['nama_gereja'] }} – Beranda</title>
    <meta name="description" content="{{ $settings['tentang_gereja'] ?? 'Portal Jemaat GEMINDO Kawan Kasih' }}">
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-dark);
            background: var(--parchment);
            overflow-x: hidden;
            line-height: 1.7;
        }

        .container { width: 100%; max-width: 1180px; margin: 0 auto; padding: 0 28px; }

        /* ═══════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════ */
        .site-header {
            position: sticky; top: 0; z-index: 1000;
            background: linear-gradient(180deg, var(--mahogany-dark) 0%, var(--mahogany) 100%);
            border-bottom: 2px solid rgba(200,148,26,.3);
        }
        /* Ornamental gold line at very top */
        .site-header::before {
            content: ''; display: block; height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold-light), var(--gold), var(--gold-light), transparent);
        }
        .nav-wrapper {
            display: flex; align-items: center;
            justify-content: space-between; height: 76px;
        }
        .logo-area { display: flex; align-items: center; gap: 14px; text-decoration: none; }
        .site-nav-logo {
            width: 44px; height: 52px; object-fit: contain; flex-shrink: 0;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,.4));
        }
        .logo-cross-wrap {
            position: relative; width: 46px; height: 54px; flex-shrink: 0;
        }
        .logo-cross-wrap::before {
            content: ''; position: absolute;
            left: 50%; top: 0; transform: translateX(-50%);
            width: 9px; height: 100%;
            background: linear-gradient(180deg, var(--gold-light), var(--gold-dark));
            border-radius: 4px;
            box-shadow: 0 0 12px rgba(200,148,26,.6);
        }
        .logo-cross-wrap::after {
            content: ''; position: absolute;
            left: 0; top: 35%;
            width: 100%; height: 9px;
            background: linear-gradient(90deg, var(--gold-light), var(--gold-dark));
            border-radius: 4px;
            box-shadow: 0 0 12px rgba(200,148,26,.6);
        }
        .logo-texts { display: flex; flex-direction: column; }
        .logo-name {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 16px; font-weight: 800; color: #fff;
            letter-spacing: -0.01em; line-height: 1.25;
        }
        .logo-sub {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 600; color: var(--gold-light); opacity: .9;
            letter-spacing: .08em; text-transform: uppercase;
        }
        .nav-menu { display: flex; align-items: center; gap: 6px; list-style: none; }
        .nav-item a {
            color: rgba(255,255,255,.8); text-decoration: none;
            font-size: 13.5px; font-weight: 600;
            padding: 8px 14px; border-radius: 6px;
            transition: all .25s ease;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            letter-spacing: -0.01em;
        }
        .nav-item a:hover { color: var(--gold-light); background: rgba(200,148,26,.1); }
        .nav-cta {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark)) !important;
            color: var(--mahogany-dark) !important; font-weight: 700 !important;
            box-shadow: 0 2px 10px rgba(200,148,26,.4);
        }
        .nav-cta:hover { box-shadow: 0 4px 16px rgba(200,148,26,.6) !important; transform: translateY(-1px); }
        .mobile-menu-btn {
            display: none; background: none; border: none; cursor: pointer;
            flex-direction: column; gap: 5px; padding: 4px;
        }
        .mobile-menu-btn span {
            display: block; width: 22px; height: 2px;
            background: rgba(255,255,255,.8); border-radius: 2px; transition: .3s;
        }

        /* ── PWA & Download Buttons ── */
        .nav-install-link {
            display: inline-flex !important; align-items: center; gap: 6px;
            background: rgba(200,148,26,.15) !important;
            border: 1px solid rgba(200,148,26,.45) !important;
            color: var(--gold-light) !important; font-weight: 700 !important;
        }
        .nav-install-link:hover {
            background: rgba(200,148,26,.28) !important;
            border-color: var(--gold-light) !important;
            color: #fff !important;
            box-shadow: 0 0 12px rgba(200,148,26,.4);
        }
        .nav-actions-mobile {
            display: none; align-items: center; gap: 8px;
        }
        .btn-mobile-install {
            display: inline-flex; align-items: center; gap: 5px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            border: none; border-radius: 6px;
            padding: 6px 12px; font-size: 12px; font-weight: 800;
            cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 2px 8px rgba(0,0,0,.3);
            transition: all .2s ease;
        }
        .btn-mobile-install:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(200,148,26,.5);
        }
        @media (max-width: 768px) {
            .nav-actions-mobile { display: flex; }
        }

        .btn-download-app {
            background: rgba(200,148,26,.14);
            border: 1.5px solid var(--gold);
            color: var(--gold-light);
            box-shadow: 0 4px 16px rgba(0,0,0,.3);
        }
        .btn-download-app:hover {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--mahogany-dark);
            box-shadow: 0 6px 20px rgba(200,148,26,.6);
            transform: translateY(-2px);
        }

        /* ── Modal Panduan Install / Unduh ── */
        .install-modal-overlay {
            position: fixed; inset: 0; z-index: 10000;
            background: rgba(10, 6, 4, 0.82);
            backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
            display: none; align-items: center; justify-content: center;
            padding: 16px;
        }
        .install-modal-overlay.open { display: flex; }
        .install-modal-card {
            background: linear-gradient(175deg, #24130d 0%, #170c08 100%);
            border: 1.5px solid rgba(200, 148, 26, 0.45);
            box-shadow: 0 20px 60px rgba(0,0,0,0.7), 0 0 35px rgba(200,148,26,0.18);
            border-radius: 18px; width: 100%; max-width: 520px;
            max-height: 90vh; overflow-y: auto;
            position: relative; padding: 26px 22px;
            color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;
            animation: modalPop .25s ease-out;
        }
        @keyframes modalPop {
            0% { transform: scale(0.94); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .modal-close-btn {
            position: absolute; top: 16px; right: 16px;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
            color: rgba(255,255,255,.7); width: 32px; height: 32px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 16px; cursor: pointer; transition: all .2s ease;
        }
        .modal-close-btn:hover { background: rgba(200,148,26,.3); color: #fff; border-color: var(--gold); }
        .modal-header-content { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
        .modal-app-icon {
            width: 52px; height: 52px; border-radius: 12px;
            border: 2px solid var(--gold); background: #1a0e09;
            object-fit: contain; padding: 3px; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,.4);
        }
        .modal-title { font-size: 18px; font-weight: 800; color: #fff; line-height: 1.25; }
        .modal-subtitle { font-size: 12.5px; color: var(--gold-light); margin-top: 3px; opacity: .9; }

        /* Direct Install Banner in Modal (for Chrome/Edge) */
        .modal-direct-install-box {
            background: linear-gradient(135deg, rgba(200,148,26,.15), rgba(200,148,26,.05));
            border: 1px solid rgba(200,148,26,.35);
            border-radius: 12px; padding: 14px 16px; margin-bottom: 20px;
            display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
        }
        .btn-prompt-install {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark); font-weight: 800; font-size: 13px;
            border: none; border-radius: 8px; padding: 10px 18px;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
            box-shadow: 0 2px 10px rgba(200,148,26,.4);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .2s;
        }
        .btn-prompt-install:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(200,148,26,.6);
        }

        /* Tabs OS */
        .modal-tabs {
            display: flex; gap: 8px; border-bottom: 1px solid rgba(255,255,255,.1);
            padding-bottom: 12px; margin-bottom: 18px;
        }
        .modal-tab-btn {
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1);
            color: rgba(255,255,255,.75); padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 700; cursor: pointer;
            transition: all .2s ease; display: inline-flex; align-items: center; gap: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .modal-tab-btn.active {
            background: rgba(200,148,26,.2); border-color: var(--gold);
            color: var(--gold-light); box-shadow: 0 0 10px rgba(200,148,26,.3);
        }

        /* Step List */
        .guide-step-list { display: flex; flex-direction: column; gap: 12px; }
        .guide-step-item {
            display: flex; align-items: flex-start; gap: 12px;
            background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.06);
            border-radius: 10px; padding: 12px 14px;
        }
        .step-num {
            width: 26px; height: 26px; border-radius: 50%;
            background: var(--gold); color: var(--mahogany-dark);
            font-weight: 800; font-size: 12.5px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }
        .step-body { font-size: 13px; line-height: 1.55; color: rgba(255,255,255,.85); }
        .step-body strong { color: var(--gold-light); font-weight: 700; }
        .step-highlight {
            display: inline-block; background: rgba(200,148,26,.18);
            border: 1px solid rgba(200,148,26,.3);
            border-radius: 4px; padding: 1px 6px; font-weight: 700;
            color: #fff; font-size: 12px; margin: 2px 0;
        }

        .pwa-benefit-box {
            margin-top: 20px; background: rgba(0,0,0,.25);
            border: 1px dashed rgba(200,148,26,.3); border-radius: 10px;
            padding: 12px 14px; font-size: 12px; color: rgba(255,255,255,.7);
            line-height: 1.6;
        }
        .pwa-benefit-box strong { color: var(--gold-light); }

        /* Action tip in install modal */
        .install-action-tip {
            background: linear-gradient(135deg, rgba(200,148,26,.28), rgba(200,148,26,.12));
            border: 1.5px solid var(--gold);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 13px;
            line-height: 1.55;
            color: #fff;
            animation: pulseGlow 1.8s infinite alternate;
        }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 8px rgba(200,148,26,.3); }
            100% { box-shadow: 0 0 20px rgba(200,148,26,.7); }
        }
        .step-pulse {
            border-color: var(--gold) !important;
            background: rgba(200,148,26,.14) !important;
            box-shadow: 0 0 12px rgba(200,148,26,.45);
            transform: scale(1.02);
            transition: all .3s ease;
        }

        /* Floating Install Bar for Mobile */
        .pwa-floating-bar {
            position: fixed; bottom: 18px; left: 16px; right: 16px; z-index: 9998;
            background: linear-gradient(135deg, #24130d 0%, #150a06 100%);
            border: 1.5px solid rgba(200, 148, 26, 0.6);
            border-radius: 14px; padding: 12px 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6), 0 0 20px rgba(200,148,26,0.25);
            display: flex; align-items: center; gap: 12px;
            animation: floatSlideUp 0.35s ease-out;
        }
        @keyframes floatSlideUp {
            0% { transform: translateY(100px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .pwa-float-icon { width: 42px; height: 42px; border-radius: 10px; border: 1.5px solid var(--gold); object-fit: contain; flex-shrink: 0; }
        .pwa-float-texts { flex: 1; min-width: 0; }
        .pwa-float-title { font-size: 13.5px; font-weight: 800; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .pwa-float-sub { font-size: 11.5px; color: var(--gold-light); opacity: 0.9; margin-top: 1px; }
        .btn-pwa-float {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark); font-weight: 800; font-size: 12.5px;
            border: none; border-radius: 8px; padding: 9px 15px;
            cursor: pointer; flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(200,148,26,0.5);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .2s;
        }
        .btn-pwa-float:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(200,148,26,0.7); }
        .btn-pwa-float-close {
            background: transparent; border: none; color: rgba(255,255,255,0.45);
            font-size: 18px; cursor: pointer; padding: 4px; line-height: 1;
            margin-left: -4px;
        }
        .btn-pwa-float-close:hover { color: #fff; }

        /* ═══════════════════════════════════════
           HERO — Full-screen church atmosphere
        ═══════════════════════════════════════ */
        .hero {
            position: relative; min-height: 92vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 80px 0 100px; overflow: hidden;
            background: linear-gradient(170deg, var(--mahogany-dark) 0%, #3d1810 30%, #4a1a0a 60%, var(--mahogany-dark) 100%);
        }
        /* Radial light rays from above — like sunlight through stained glass */
        .hero::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% -10%, rgba(200,148,26,.18) 0%, transparent 65%),
                radial-gradient(ellipse 40% 30% at 20% 80%, rgba(107,26,46,.15) 0%, transparent 55%),
                radial-gradient(ellipse 40% 30% at 80% 80%, rgba(107,26,46,.12) 0%, transparent 55%);
            animation: lightray 10s ease-in-out infinite alternate;
            pointer-events: none;
        }
        @keyframes lightray {
            from { opacity: .7; }
            to   { opacity: 1; }
        }
        /* Stained-glass lattice */
        .hero::after {
            content: ''; position: absolute; inset: 0; opacity: .035;
            background-image:
                linear-gradient(rgba(200,148,26,1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(200,148,26,1) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }
        /* Left & right arch shapes */
        .hero-arch-l, .hero-arch-r {
            position: absolute; top: 0; width: 280px; height: 100%;
            pointer-events: none;
        }
        .hero-arch-l {
            left: 0;
            background: linear-gradient(90deg, rgba(200,148,26,.06), transparent);
        }
        .hero-arch-r {
            right: 0;
            background: linear-gradient(270deg, rgba(200,148,26,.06), transparent);
        }

        .hero-content { position: relative; z-index: 2; max-width: 840px; margin: 0 auto; padding: 0 20px; }

        /* Official Church Logo in Hero with Sacred Gold Glow */
        .hero-logo-wrap {
            position: relative; width: 110px; height: 130px;
            margin: 0 auto 24px; display: flex; align-items: center; justify-content: center;
        }
        .hero-logo-glow {
            position: absolute; inset: -20px; border-radius: 50%;
            background: radial-gradient(circle, rgba(200,148,26,.32) 0%, rgba(200,148,26,0) 70%);
            filter: blur(14px); pointer-events: none;
            animation: hero-glow-pulse 4s ease-in-out infinite alternate;
        }
        @keyframes hero-glow-pulse {
            0% { transform: scale(0.92); opacity: 0.6; }
            100% { transform: scale(1.15); opacity: 1; }
        }
        .hero-logo-img {
            width: 100%; height: 100%; object-fit: contain;
            position: relative; z-index: 1;
            filter: drop-shadow(0 6px 20px rgba(0,0,0,.6)) drop-shadow(0 0 16px rgba(200,148,26,.45));
        }

        /* Large decorative cross above title (fallback) */
        .hero-cross-large {
            position: relative; width: 60px; height: 80px;
            margin: 0 auto 32px;
        }
        .hero-cross-large::before {
            content: ''; position: absolute;
            left: 50%; top: 0; transform: translateX(-50%);
            width: 10px; height: 100%;
            background: linear-gradient(180deg, rgba(200,148,26,.3), var(--gold-light), var(--gold-dark), rgba(200,148,26,.3));
            border-radius: 5px;
            box-shadow: 0 0 30px rgba(200,148,26,.5), 0 0 60px rgba(200,148,26,.2);
        }
        .hero-cross-large::after {
            content: ''; position: absolute;
            left: 0; top: 30%;
            width: 100%; height: 10px;
            background: linear-gradient(90deg, rgba(200,148,26,.3), var(--gold-light), var(--gold-dark), rgba(200,148,26,.3));
            border-radius: 5px;
            box-shadow: 0 0 30px rgba(200,148,26,.5), 0 0 60px rgba(200,148,26,.2);
        }

        /* Ornamental divider line */
        .hero-ornament {
            display: flex; align-items: center; gap: 14px;
            justify-content: center; margin-bottom: 24px;
        }
        .hero-ornament::before, .hero-ornament::after {
            content: ''; flex: 1; max-width: 120px; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(200,148,26,.6));
        }
        .hero-ornament::after { background: linear-gradient(270deg, transparent, rgba(200,148,26,.6)); }
        .hero-ornament span {
            font-size: 15px; color: var(--gold-light); opacity: .85;
            font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: .2em; font-weight: 700;
        }

        .hero-eyebrow {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px; font-weight: 700; color: var(--gold-light); opacity: .9;
            letter-spacing: .15em; text-transform: uppercase;
            margin-bottom: 16px;
        }
        .hero-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(28px, 5.2vw, 50px);
            font-weight: 800; color: #fff;
            line-height: 1.2; margin-bottom: 20px;
            letter-spacing: -0.025em;
            text-shadow: 0 2px 20px rgba(0,0,0,.5);
        }
        .hero-title span { color: var(--gold-light); }

        .hero-verse {
            font-family: 'EB Garamond', serif;
            font-size: 19px; color: rgba(255,255,255,.8);
            font-style: italic; line-height: 1.7;
            margin: 0 auto 10px; max-width: 640px;
        }
        .hero-verse-ref {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; font-weight: 600; color: var(--gold-light); opacity: .85;
            letter-spacing: .06em; margin-bottom: 36px; display: block;
        }

        .hero-tagline {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15.5px; color: rgba(255,255,255,.7);
            max-width: 580px; margin: 0 auto 40px;
            line-height: 1.8; font-weight: 400;
        }

        .hero-buttons { display: flex; align-items: center; justify-content: center; gap: 16px; flex-wrap: wrap; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 13px 28px; border-radius: 8px;
            font-size: 14px; font-weight: 700;
            text-decoration: none; transition: all .3s ease;
            cursor: pointer; border: none; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            letter-spacing: -0.01em;
        }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            box-shadow: 0 4px 16px rgba(200,148,26,.45);
        }
        .btn-gold:hover { box-shadow: 0 6px 24px rgba(200,148,26,.6); transform: translateY(-2px); }
        .btn-ghost {
            background: rgba(255,255,255,.06); border: 1.5px solid rgba(200,148,26,.4);
            color: rgba(255,255,255,.9);
        }
        .btn-ghost:hover { background: rgba(200,148,26,.12); border-color: var(--gold-light); transform: translateY(-2px); }

        /* Scroll indicator */
        .hero-scroll {
            position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
            color: rgba(200,148,26,.65); font-size: 11px; letter-spacing: .12em;
            text-transform: uppercase; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            animation: scrollbob 2.5s ease-in-out infinite;
        }
        .hero-scroll::after {
            content: ''; width: 1px; height: 40px;
            background: linear-gradient(180deg, rgba(200,148,26,.4), transparent);
        }
        @keyframes scrollbob { 0%,100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(6px); } }

        /* Wave divider */
        .wave-divider { display: block; width: 100%; overflow: hidden; line-height: 0; }
        .wave-divider svg { display: block; }

        /* ═══════════════════════════════════════
           SECTIONS — General
        ═══════════════════════════════════════ */
        .section { padding: 90px 0; }
        .section-alt { background: linear-gradient(180deg, var(--cream) 0%, var(--parchment) 100%); }
        .section-dark {
            background: linear-gradient(170deg, var(--mahogany-dark), var(--mahogany));
            color: #fff;
        }

        /* Section header with ornamental divider */
        .section-header { text-align: center; margin-bottom: 56px; }
        .section-ornament {
            display: flex; align-items: center; justify-content: center; gap: 12px;
            margin-bottom: 16px;
        }
        .section-ornament::before, .section-ornament::after {
            content: ''; flex: 1; max-width: 80px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold));
        }
        .section-ornament::after { background: linear-gradient(270deg, transparent, var(--gold)); }
        .section-ornament-symbol {
            color: var(--gold); font-size: 16px; font-family: 'Cinzel', serif;
        }
        .section-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: clamp(24px, 4vw, 34px);
            font-weight: 800; color: var(--mahogany);
            margin-bottom: 12px; letter-spacing: -0.02em;
        }
        .section-dark .section-title { color: var(--gold-light); }
        .section-subtitle {
            font-family: 'EB Garamond', serif;
            font-size: 17px; color: var(--text-muted);
            max-width: 580px; margin: 0 auto;
            font-style: italic; line-height: 1.7;
        }
        .section-dark .section-subtitle { color: rgba(255,255,255,.6); }

        /* ═══════════════════════════════════════
           JADWAL IBADAH
        ═══════════════════════════════════════ */
        .jadwal-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; }
        .jadwal-card {
            background: var(--ivory);
            border-radius: 14px;
            border: 1px solid var(--border-warm);
            border-left: 5px solid var(--gold);
            padding: 28px 26px;
            box-shadow: 0 4px 20px rgba(44,24,16,.07);
            transition: all .3s ease;
            position: relative; overflow: hidden;
        }
        .jadwal-card::before {
            content: '✝';
            position: absolute; top: -10px; right: 16px;
            font-size: 80px; color: rgba(200,148,26,.05);
            font-family: 'EB Garamond', serif; line-height: 1;
            pointer-events: none;
        }
        .jadwal-card:hover { transform: translateY(-5px); box-shadow: 0 12px 36px rgba(44,24,16,.14); border-left-color: var(--gold-dark); }
        .jadwal-day-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 800;
            padding: 4px 12px; border-radius: 20px;
            letter-spacing: .06em; text-transform: uppercase;
            margin-bottom: 14px;
        }
        .jadwal-name {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 18px; font-weight: 700;
            color: var(--mahogany); margin-bottom: 14px;
            letter-spacing: -0.01em;
        }
        .jadwal-time {
            font-size: 13.5px; font-weight: 700;
            color: var(--gold-dark);
            margin-bottom: 10px; letter-spacing: .01em;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .jadwal-meta { display: flex; flex-direction: column; gap: 6px; }
        .jadwal-meta-item { display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: var(--text-muted); }
        .jadwal-meta-item svg { width: 15px; height: 15px; flex-shrink: 0; color: var(--gold-dark); }

        /* ═══════════════════════════════════════
           AYAT HARI INI — Inspirational strip
        ═══════════════════════════════════════ */
        .verse-strip {
            background: linear-gradient(135deg, var(--mahogany-dark) 0%, var(--mahogany) 50%, var(--mahogany-mid) 100%);
            padding: 60px 0;
            text-align: center; position: relative; overflow: hidden;
        }
        .verse-strip::before {
            content: '"'; position: absolute;
            left: 40px; top: -30px; font-size: 200px;
            font-family: 'EB Garamond', serif;
            color: rgba(200,148,26,.07); line-height: 1;
        }
        .verse-strip::after {
            content: '"'; position: absolute;
            right: 40px; bottom: -60px; font-size: 200px;
            font-family: 'EB Garamond', serif;
            color: rgba(200,148,26,.07); line-height: 1;
        }
        .verse-strip-text {
            font-family: 'EB Garamond', serif;
            font-size: clamp(20px, 3vw, 28px);
            color: rgba(255,255,255,.9); font-style: italic;
            line-height: 1.65; max-width: 760px; margin: 0 auto 16px;
            position: relative;
        }
        .verse-strip-ref {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px; font-weight: 700; color: var(--gold-light); letter-spacing: .08em;
        }

        /* ═══════════════════════════════════════
           PENGUMUMAN
        ═══════════════════════════════════════ */
        .pengumuman-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; }
        .pengumuman-card {
            background: var(--ivory);
            border-radius: 14px;
            border: 1px solid var(--border-warm);
            padding: 28px 26px;
            box-shadow: 0 4px 16px rgba(44,24,16,.06);
            display: flex; flex-direction: column;
            transition: all .3s ease; position: relative;
        }
        .pengumuman-card:hover { transform: translateY(-4px); box-shadow: 0 10px 32px rgba(44,24,16,.12); }
        /* Top gold border on hover */
        .pengumuman-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
            border-radius: 14px 14px 0 0; opacity: 0; transition: opacity .3s;
        }
        .pengumuman-card:hover::before { opacity: 1; }
        .pengumuman-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, rgba(200,148,26,.15), rgba(200,148,26,.05));
            border: 1px solid rgba(200,148,26,.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; margin-bottom: 16px;
        }
        .pengumuman-date {
            font-size: 12px; font-weight: 700;
            color: var(--gold-dark); text-transform: uppercase;
            letter-spacing: .05em; margin-bottom: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .pengumuman-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 16.5px; font-weight: 700;
            color: var(--mahogany); margin-bottom: 12px; line-height: 1.4;
            letter-spacing: -0.01em;
        }
        .pengumuman-body {
            font-family: 'EB Garamond', serif;
            font-size: 16px; color: var(--text-muted);
            line-height: 1.7; flex-grow: 1;
        }

        /* ═══════════════════════════════════════
           KEGIATAN
        ═══════════════════════════════════════ */
        .kegiatan-list { display: flex; flex-direction: column; gap: 18px; max-width: 780px; margin: 0 auto; }
        .kegiatan-item {
            display: flex; gap: 20px; align-items: flex-start;
            background: rgba(255,255,255,.06); border: 1px solid rgba(200,148,26,.15);
            border-radius: 14px; padding: 22px 26px;
            transition: all .3s ease;
        }
        .kegiatan-item:hover { background: rgba(200,148,26,.08); border-color: rgba(200,148,26,.3); transform: translateX(4px); }
        .kegiatan-date-badge {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            min-width: 64px; height: 64px; border-radius: 12px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            flex-shrink: 0; font-weight: 700; line-height: 1.1;
        }
        .kegiatan-date-day { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; }
        .kegiatan-date-month { font-size: 10.5px; text-transform: uppercase; letter-spacing: .05em; opacity: .85; font-weight: 700; }
        .kegiatan-title { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-size: 16.5px; font-weight: 700; color: #fff; margin-bottom: 6px; letter-spacing: -0.01em; }
        .kegiatan-desc { font-family: 'EB Garamond', serif; font-size: 15px; color: rgba(255,255,255,.6); margin-bottom: 8px; font-style: italic; }
        .kegiatan-loc { font-size: 12.5px; color: var(--gold-light); font-weight: 600; display: flex; align-items: center; gap: 5px; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ═══════════════════════════════════════
           PERSEMBAHAN CTA
        ═══════════════════════════════════════ */
        .persembahan-cta {
            position: relative; border-radius: 20px; overflow: hidden;
            background: linear-gradient(145deg, var(--mahogany-dark) 0%, #4a1a0a 50%, var(--mahogany-dark) 100%);
            padding: 72px 60px; text-align: center;
            box-shadow: 0 24px 60px rgba(44,24,16,.3);
            border: 1px solid rgba(200,148,26,.2);
        }
        .persembahan-cta > * {
            position: relative;
            z-index: 2;
        }
        /* Inner gold glow */
        .persembahan-cta::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(200,148,26,.08) 0%, transparent 70%);
            animation: pulse-glow 4s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }
        @keyframes pulse-glow { 0%,100%{opacity:.6} 50%{opacity:1} }
        /* Large watermark cross */
        .persembahan-cta::after {
            content: '✝'; position: absolute;
            right: -40px; top: 50%; transform: translateY(-50%);
            font-size: 320px; color: rgba(200,148,26,.04);
            font-family: 'Cinzel', serif; line-height: 1;
            pointer-events: none;
            z-index: 1;
        }
        .cta-ornament {
            display: flex; align-items: center; justify-content: center; gap: 14px;
            margin-bottom: 24px;
        }
        .cta-ornament::before, .cta-ornament::after {
            content: ''; width: 60px; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(200,148,26,.5));
        }
        .cta-ornament::after { background: linear-gradient(270deg, transparent, rgba(200,148,26,.5)); }
        .cta-ornament span { font-size: 20px; color: var(--gold-light); font-family: 'Cinzel', serif; }
        .cta-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: clamp(24px, 4vw, 34px);
            font-weight: 800; color: var(--gold-light);
            margin-bottom: 14px; position: relative; letter-spacing: -0.02em;
        }
        .cta-verse {
            font-family: 'EB Garamond', serif;
            font-size: 18px; color: rgba(255,255,255,.7);
            font-style: italic; margin-bottom: 8px; max-width: 600px; margin-left: auto; margin-right: auto;
        }
        .cta-verse-ref { font-size: 13px; color: rgba(200,148,26,.7); letter-spacing: .06em; margin-bottom: 32px; display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; }
        .cta-desc { font-size: 15px; color: rgba(255,255,255,.6); max-width: 540px; margin: 0 auto 36px; line-height: 1.8; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ═══════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════ */
        footer.site-footer {
            background: linear-gradient(180deg, var(--mahogany-dark), #0e0806);
            color: rgba(255,255,255,.65); padding: 72px 0 32px;
            font-size: 14px;
            border-top: 1px solid rgba(200,148,26,.2);
        }
        footer.site-footer::before {
            content: ''; display: block; height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold-dark), var(--gold-light), var(--gold-dark), transparent);
            margin-bottom: 0;
        }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 48px; margin-bottom: 48px; }
        .footer-brand { display: flex; align-items: center; gap: 13px; margin-bottom: 18px; }
        .footer-logo-img {
            width: 36px; height: 44px; object-fit: contain; flex-shrink: 0;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,.4));
        }
        .footer-cross {
            position: relative; width: 32px; height: 40px; flex-shrink: 0;
        }
        .footer-cross::before {
            content: ''; position: absolute; left: 50%; top: 0; transform: translateX(-50%);
            width: 6px; height: 100%; background: linear-gradient(180deg, var(--gold-light), var(--gold-dark)); border-radius: 3px;
        }
        .footer-cross::after {
            content: ''; position: absolute; left: 0; top: 35%;
            width: 100%; height: 6px; background: linear-gradient(90deg, var(--gold-light), var(--gold-dark)); border-radius: 3px;
        }
        .footer-brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16.5px; font-weight: 800; color: #fff; letter-spacing: -0.01em;
        }
        .footer-tagline {
            font-family: 'EB Garamond', serif; font-size: 15px;
            color: rgba(255,255,255,.45); font-style: italic;
            line-height: 1.7; margin-bottom: 22px; max-width: 340px;
        }
        .footer-verse {
            background: rgba(200,148,26,.07); border-left: 3px solid rgba(200,148,26,.3);
            padding: 12px 16px; border-radius: 0 8px 8px 0;
            font-family: 'EB Garamond', serif; font-size: 14px;
            color: rgba(255,255,255,.5); font-style: italic; line-height: 1.6;
            max-width: 340px;
        }
        .footer-section-title {
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800;
            color: var(--gold-light); margin-bottom: 20px; letter-spacing: .06em;
            text-transform: uppercase; padding-bottom: 10px;
            border-bottom: 1px solid rgba(200,148,26,.2);
        }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-links a {
            color: rgba(255,255,255,.55); text-decoration: none;
            font-size: 13.5px; transition: all .2s ease;
            display: flex; align-items: center; gap: 8px;
        }
        .footer-links a::before { content: '✦'; font-size: 8px; color: rgba(200,148,26,.4); }
        .footer-links a:hover { color: var(--gold-light); padding-left: 4px; }
        .footer-links a:hover::before { color: var(--gold-light); }
        .contact-list { display: flex; flex-direction: column; gap: 14px; }
        .contact-item { display: flex; align-items: flex-start; gap: 10px; }
        .contact-item svg { width: 16px; height: 16px; color: var(--gold); flex-shrink: 0; margin-top: 3px; }
        .contact-item span { font-size: 13.5px; color: rgba(255,255,255,.55); line-height: 1.5; }
        .footer-divider {
            border: none; border-top: 1px solid rgba(255,255,255,.06);
            margin: 0 0 28px;
        }
        .footer-bottom {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-copy {
            font-size: 12.5px; color: rgba(255,255,255,.3);
            font-family: 'EB Garamond', serif; font-style: italic;
        }
        .social-links { display: flex; gap: 10px; }
        .social-link {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(200,148,26,.08); border: 1px solid rgba(200,148,26,.2);
            color: rgba(255,255,255,.6); display: flex; align-items: center;
            justify-content: center; text-decoration: none; font-size: 13px;
            font-weight: 700; transition: all .25s ease;
        }
        .social-link:hover { background: var(--gold); border-color: var(--gold); color: var(--mahogany-dark); transform: translateY(-3px); }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 992px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .mobile-menu-btn { display: flex; }
            .nav-menu.open { display: flex; flex-direction: column; position: absolute; top: 100%; left: 0; right: 0; background: var(--mahogany-dark); padding: 16px; gap: 4px; border-top: 1px solid rgba(200,148,26,.2); }
            .site-header { position: relative; }
            .footer-grid { grid-template-columns: 1fr; }
            .persembahan-cta { padding: 48px 28px; }
            .hero { min-height: 80vh; }
            .section { padding: 64px 0; }
        }

        /* Fade-in animation on scroll */
        .fade-up { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* ═══════════════════════════════════════
           MOBILE RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .mobile-menu-btn { display: flex; }
            .nav-menu.open {
                display: flex; flex-direction: column;
                position: absolute; top: 100%; left: 0; right: 0;
                background: var(--mahogany-dark); padding: 12px;
                gap: 4px; border-top: 1px solid rgba(200,148,26,.2);
                box-shadow: 0 8px 24px rgba(0,0,0,.4);
                z-index: 999;
            }
            .nav-menu.open .nav-item a { padding: 12px 16px; display: block; border-radius: 8px; }
            .site-header { position: relative; }
            .footer-grid { grid-template-columns: 1fr; gap: 28px; }
            .persembahan-cta { padding: 40px 22px; }
            .hero { min-height: 80vh; padding: 60px 0 80px; }
            .hero-cross-large { width: 44px; height: 60px; margin-bottom: 24px; }
            .section { padding: 60px 0; }
            .container { padding: 0 18px; }
            /* Jadwal cards stack full-width */
            .jadwal-grid { grid-template-columns: 1fr; gap: 16px; }
            /* Kegiatan items */
            .kegiatan-item { padding: 18px 18px; gap: 14px; }
            .kegiatan-date-badge { min-width: 54px; height: 54px; }
            .kegiatan-date-day { font-size: 18px; }
            /* Footer bottom */
            .footer-bottom { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
        @media (max-width: 480px) {
            .hero-title { font-size: clamp(22px, 7vw, 36px); }
            .hero-verse { font-size: 16px; }
            .hero-buttons { flex-direction: column; gap: 10px; }
            .hero-buttons .btn { width: 100%; }
            .jadwal-card { padding: 20px 18px; }
            .pengumuman-grid { grid-template-columns: 1fr; }
            .kegiatan-list { padding: 0 4px; }
            .persembahan-cta { padding: 32px 18px; }
            .persembahan-cta::after { display: none; /* hide watermark cross on tiny screens */ }
        }
        @media (max-width: 360px) {
            .nav-wrapper { height: 60px; }
            .logo-name { font-size: 14px; }
            .container { padding: 0 14px; }
        }
        /* iPhone safe area */
        @supports (padding-top: env(safe-area-inset-top)) {
            .site-header { padding-top: env(safe-area-inset-top); }
            .hero-scroll { bottom: calc(28px + env(safe-area-inset-bottom)); }
        }
    </style>
</head>
<body>

<!-- ══ NAVBAR ══ -->
<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="nav-wrapper">
            <a href="{{ route('home') }}" class="logo-area">
                <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="site-nav-logo">
                <div class="logo-texts">
                    <div class="logo-name">{{ $settings['nama_gereja'] }}</div>
                    <div class="logo-sub">Portal Jemaat</div>
                </div>
            </a>
            <div class="nav-actions-mobile">
                <button type="button" class="btn-mobile-install" onclick="openInstallModal()" aria-label="Unduh Aplikasi">
                    <span>📲 App</span>
                </button>
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item"><a href="#beranda">Beranda</a></li>
                <li class="nav-item"><a href="#jadwal">Jadwal Ibadah</a></li>
                <li class="nav-item"><a href="#pengumuman">Warta Jemaat</a></li>
                <li class="nav-item"><a href="#kegiatan">Kegiatan</a></li>
                <li class="nav-item"><a href="{{ route('persembahan.index') }}">Persembahan</a></li>
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="openInstallModal()" class="nav-install-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Unduh App</span>
                    </a>
                </li>
                @guest
                    <li class="nav-item"><a href="{{ route('daftar-jemaat') }}">Daftar Jemaat</a></li>
                @endguest
                @auth
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-cta">Masuk</a></li>
                @endauth
            </ul>
        </div>
    </div>
</header>

<!-- ══ HERO ══ -->
<section class="hero" id="beranda">
    <div class="hero-arch-l"></div>
    <div class="hero-arch-r"></div>
    <div class="hero-content">
        <div class="hero-logo-wrap">
            <div class="hero-logo-glow"></div>
            <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="hero-logo-img">
        </div>

        <p class="hero-eyebrow">GEREJA MASEHI INJILI INDONESIA</p>

        <div class="hero-ornament">
            <span>✦ ✝ ✦</span>
        </div>

        <h1 class="hero-title">
            Selamat Datang di<br>
            <span>{{ $settings['nama_gereja'] }}</span>
        </h1>

        <p class="hero-verse">
            "Sebab segala sesuatu adalah dari Dia, dan oleh Dia, dan kepada Dia: Bagi Dialah kemuliaan sampai selama-lamanya!"
        </p>
        <cite class="hero-verse-ref">— Roma 11:36</cite>

        <p class="hero-tagline">
            {{ $settings['tentang_gereja'] ?: 'Gereja yang bersekutu, bersaksi, dan melayani dengan penuh kasih di tengah-tengah jemaat dan masyarakat.' }}
        </p>

        <div class="hero-buttons">
            <a href="{{ route('persembahan.index') }}" class="btn btn-gold">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Persembahan Online
            </a>
            <button type="button" onclick="openInstallModal()" class="btn btn-download-app">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Unduh Aplikasi HP
            </button>
            @guest
            <a href="{{ route('daftar-jemaat') }}" class="btn btn-ghost">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Daftar Jemaat Baru
            </a>
            @endguest
        </div>
    </div>

    <div class="hero-scroll">Gulir</div>
</section>

<!-- ══ JADWAL IBADAH ══ -->
<section class="section" id="jadwal">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-ornament">
                <span class="section-ornament-symbol">✝</span>
            </div>
            <h2 class="section-title">Jadwal Ibadah</h2>
            <p class="section-subtitle">Mari bergabung bersama kami dalam persekutuan ibadah. "Di mana ada dua atau tiga orang berkumpul dalam nama-Ku, Aku hadir." — Mat. 18:20</p>
        </div>
        <div class="jadwal-grid">
            @forelse($jadwals as $jadwal)
            <div class="jadwal-card fade-up">
                <div class="jadwal-day-badge">{{ $jadwal->hari }}</div>
                <h3 class="jadwal-name">{{ $jadwal->nama }}</h3>
                <div class="jadwal-time">
                    🕐 {{ substr($jadwal->waktu_mulai, 0, 5) }}{{ $jadwal->waktu_selesai ? ' – ' . substr($jadwal->waktu_selesai, 0, 5) : '' }} WIB
                </div>
                <div class="jadwal-meta">
                    <div class="jadwal-meta-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $jadwal->lokasi ?: 'Gedung Gereja Utama' }}
                    </div>
                    @if($jadwal->pelayan_firman)
                    <div class="jadwal-meta-item" style="display: block; text-align: left;">
                        <div style="color:var(--gold-dark);font-weight:600;font-size:12.5px;margin-bottom:2px;">📖 Pelayan Firman :</div>
                        <div style="font-size:13px;padding-left:22px;color:var(--text-dark);font-weight:500;">{{ $jadwal->pelayan_firman }}</div>
                    </div>
                    @endif
                    @if($jadwal->worship_leader)
                    <div class="jadwal-meta-item">
                        <span style="color:var(--gold-dark);font-weight:600;font-size:12.5px;">🎤 WL :</span>
                        <span style="font-size:13px;">{{ $jadwal->worship_leader }}</span>
                    </div>
                    @endif
                    @if($jadwal->pengajar)
                    <div class="jadwal-meta-item">
                        <span style="color:var(--gold-dark);font-weight:600;font-size:12.5px;">🎓 Pengajar :</span>
                        <span style="font-size:13px;">{{ $jadwal->pengajar }}</span>
                    </div>
                    @endif
                    @if($jadwal->pemusik)
                    <div class="jadwal-meta-item">
                        <span style="color:var(--gold-dark);font-weight:600;font-size:12.5px;">🎹 Pemusik :</span>
                        <span style="font-size:13px;">{{ $jadwal->pemusik }}</span>
                    </div>
                    @endif
                    @if($jadwal->keterangan)
                    <div class="jadwal-meta-item" style="font-style:italic;color:var(--text-muted);margin-top:4px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $jadwal->keterangan }}
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--text-muted);">
                <div style="font-size:40px;margin-bottom:12px;">🕊️</div>
                <p style="font-family:'EB Garamond',serif;font-size:17px;font-style:italic;">Belum ada jadwal ibadah aktif saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ══ VERSE STRIP ══ -->
<div class="verse-strip">
    <div class="container">
        <p class="verse-strip-text">
            "Datanglah kepada-Ku, semua yang letih lesu dan berbeban berat, Aku akan memberi kelegaan kepadamu."
        </p>
        <div class="verse-strip-ref">— Matius 11:28</div>
    </div>
</div>

<!-- ══ PENGUMUMAN / WARTA JEMAAT ══ -->
<section class="section section-alt" id="pengumuman">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-ornament">
                <span class="section-ornament-symbol">✦</span>
            </div>
            <h2 class="section-title">Warta Jemaat</h2>
            <p class="section-subtitle">Informasi dan kabar terkini seputar kegiatan pelayanan gereja kita.</p>
        </div>
        <div class="pengumuman-grid">
            @forelse($pengumumans as $p)
            <div class="pengumuman-card fade-up">
                <div class="pengumuman-icon">📣</div>
                <div class="pengumuman-date">{{ $p->tanggal_mulai->format('d M Y') }}@if($p->tanggal_selesai) s.d. {{ $p->tanggal_selesai->format('d M Y') }}@endif</div>
                <h3 class="pengumuman-title">{{ $p->judul }}</h3>
                <p class="pengumuman-body">{{ Str::limit($p->isi, 140) }}</p>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--text-muted);">
                <div style="font-size:40px;margin-bottom:12px;">📜</div>
                <p style="font-family:'EB Garamond',serif;font-size:17px;font-style:italic;">Belum ada warta atau pengumuman saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ══ KEGIATAN MENDATANG ══ -->
<section class="section section-dark" id="kegiatan">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-ornament">
                <span class="section-ornament-symbol" style="color:var(--gold-light);">✝</span>
            </div>
            <h2 class="section-title">Kegiatan Mendatang</h2>
            <p class="section-subtitle">Aktivitas dan persekutuan yang akan diselenggarakan dalam waktu dekat.</p>
        </div>
        <div class="kegiatan-list">
            @forelse($kegiatans as $k)
            <div class="kegiatan-item fade-up">
                <div class="kegiatan-date-badge">
                    <span class="kegiatan-date-day">{{ $k->tanggal_mulai->format('d') }}</span>
                    <span class="kegiatan-date-month">{{ $k->tanggal_mulai->isoFormat('MMM') }}</span>
                </div>
                <div>
                    <h3 class="kegiatan-title">{{ $k->nama }}</h3>
                    <p class="kegiatan-desc">{{ $k->deskripsi }}</p>
                    <div class="kegiatan-loc">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $k->lokasi }} &nbsp;|&nbsp; Pkl {{ $k->tanggal_mulai->format('H:i') }} WIB
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px;color:rgba(255,255,255,.4);">
                <div style="font-size:40px;margin-bottom:12px;">🕊️</div>
                <p style="font-family:'EB Garamond',serif;font-size:17px;font-style:italic;">Tidak ada kegiatan mendatang yang dijadwalkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ══ CTA PERSEMBAHAN ══ -->
<section class="section" style="background:var(--cream);">
    <div class="container">
        <div class="persembahan-cta fade-up">
            <div class="cta-ornament"><span>✝</span></div>
            <h2 class="cta-title">Mendukung Pelayanan Gereja</h2>
            <p class="cta-verse">"Berilah dan kamu akan diberi: suatu takaran yang baik, yang dipadatkan, yang diguncang dan yang tumpah ke luar..."</p>
            <cite class="cta-verse-ref">— Lukas 6:38</cite>
            <p class="cta-desc">
                Nyatakan ucapan syukur Anda dengan mendukung pelayanan gereja secara digital. Salurkan persembahan, perpuluhan, maupun donasi kasih melalui sistem pembayaran kami.
            </p>
            <a href="{{ route('persembahan.index') }}" class="btn btn-gold" style="font-size:15px;padding:15px 36px;position:relative;z-index:10;display:inline-flex;align-items:center;justify-content:center;gap:8px;cursor:pointer;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Beri Persembahan Digital
            </a>
        </div>
    </div>
</section>

<!-- ══ FOOTER ══ -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- About -->
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="footer-logo-img">
                    <div class="footer-brand-name">{{ $settings['nama_gereja'] }}</div>
                </div>
                <p class="footer-tagline">Melayani Tuhan dan jemaat-Nya dengan integritas, kebenaran, dan kasih kristiani demi kemuliaan nama-Nya semata.</p>
                <div class="footer-verse">
                    "Tuhan adalah gembalaku, takkan kekurangan aku." — Mazmur 23:1
                </div>
            </div>
            <!-- Links -->
            <div>
                <div class="footer-section-title">Tautan Cepat</div>
                <ul class="footer-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#jadwal">Jadwal Ibadah</a></li>
                    <li><a href="#pengumuman">Warta Jemaat</a></li>
                    <li><a href="{{ route('persembahan.index') }}">Persembahan Online</a></li>
                    <li><a href="javascript:void(0)" onclick="openInstallModal()">📲 Pasang Aplikasi HP</a></li>
                    @guest<li><a href="{{ route('daftar-jemaat') }}">Daftar Jemaat Baru</a></li>@endguest
                    <li><a href="{{ route('login') }}">Portal Masuk</a></li>
                </ul>
            </div>
            <!-- Contact -->
            <div>
                <div class="footer-section-title">Kontak Kami</div>
                <div class="contact-list">
                    @if($settings['alamat_gereja'])
                    <div class="contact-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $settings['alamat_gereja'] }}</span>
                    </div>
                    @endif
                    @if($settings['telepon_gereja'])
                    <div class="contact-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $settings['telepon_gereja'] }}</span>
                    </div>
                    @endif
                    @if($settings['email_gereja'])
                    <div class="contact-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $settings['email_gereja'] }}</span>
                    </div>
                    @endif
                    @if(!empty($settings['nama_pendeta']))
                    <div class="contact-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>{{ $settings['nama_pendeta'] }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} {{ $settings['nama_gereja'] }}. Soli Deo Gloria.</p>
            <div class="social-links">
                @if(!empty($settings['facebook_url']) && $settings['facebook_url'] !== '#')
                    <a href="{{ $settings['facebook_url'] }}" class="social-link" target="_blank" rel="noopener">f</a>
                @endif
                @if(!empty($settings['instagram_url']) && $settings['instagram_url'] !== '#')
                    <a href="{{ $settings['instagram_url'] }}" class="social-link" target="_blank" rel="noopener">ig</a>
                @endif
                @if(!empty($settings['youtube_url']) && $settings['youtube_url'] !== '#')
                    <a href="{{ $settings['youtube_url'] }}" class="social-link" target="_blank" rel="noopener">▶</a>
                @endif
            </div>
        </div>
    </div>
</footer>

<!-- ══ MODAL PANDUAN UNDUH / INSTALL APLIKASI (PWA) ══ -->
<div class="install-modal-overlay" id="installModal" onclick="handleModalBackdropClick(event)">
    <div class="install-modal-card" role="dialog" aria-modal="true" aria-labelledby="modalInstallTitle">
        <button type="button" class="modal-close-btn" onclick="closeInstallModal()" aria-label="Tutup Modal">✕</button>

        <div class="modal-header-content">
            <img src="{{ asset('icons/icon-96x96.png') }}" alt="Logo GEMINDO KK" class="modal-app-icon">
            <div>
                <h3 class="modal-title" id="modalInstallTitle">Pasang Aplikasi GEMINDO KK</h3>
                <p class="modal-subtitle">Akses cepat di layar HP Anda tanpa Play Store</p>
            </div>
        </div>

        <!-- 1-Click Install Notification (ALWAYS VISIBLE & ACTIONABLE) -->
        <div id="directInstallBox" class="modal-direct-install-box" style="display:flex;">
            <div>
                <div style="font-weight:700;font-size:13.5px;color:#fff;">Pasang Langsung ke Layar HP</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Aplikasi ringan &lt; 1MB, otomatis update warta & persembahan.</div>
            </div>
            <button type="button" class="btn-prompt-install" onclick="triggerPwaPrompt()">
                <span>📲 Pasang Sekarang</span>
            </button>
        </div>

        <!-- Status / Action Tip Area -->
        <div id="installStatusNotice" style="display:none;"></div>

        <!-- Tabs OS -->
        <div class="modal-tabs">
            <button type="button" class="modal-tab-btn active" id="tabBtnAndroid" onclick="switchInstallTab('android')">
                <span>🤖 Android (Chrome)</span>
            </button>
            <button type="button" class="modal-tab-btn" id="tabBtnIos" onclick="switchInstallTab('ios')">
                <span>🍎 iPhone (Safari)</span>
            </button>
        </div>

        <!-- Android Guide -->
        <div id="guideAndroid" class="guide-content">
            <div class="guide-step-list">
                <div class="guide-step-item">
                    <div class="step-num">1</div>
                    <div class="step-body">
                        Buka link web ini di browser <strong>Google Chrome</strong> pada HP Android Anda.
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="step-num">2</div>
                    <div class="step-body">
                        Ketuk ikon titik tiga <span class="step-highlight">⋮</span> di pojok kanan atas browser Chrome.
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="step-num">3</div>
                    <div class="step-body">
                        Pilih menu <span class="step-highlight">Tambahkan ke Layar Utama</span> atau <span class="step-highlight">Pasang Aplikasi</span> (*Install app*).
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="step-num">4</div>
                    <div class="step-body">
                        Ketuk <strong>"Install"</strong> / <strong>"Tambah"</strong>. Ikon aplikasi GEMINDO KK siap digunakan langsung di layar HP!
                    </div>
                </div>
            </div>
        </div>

        <!-- iOS Guide -->
        <div id="guideIos" class="guide-content" style="display:none;">
            <div class="guide-step-list">
                <div class="guide-step-item">
                    <div class="step-num">1</div>
                    <div class="step-body">
                        Buka link web ini di browser bawaan <strong>Safari</strong> pada iPhone atau iPad Anda.
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="step-num">2</div>
                    <div class="step-body">
                        Ketuk tombol <strong>Share / Bagikan</strong> di bilah bawah Safari <span class="step-highlight">ikon kotak panah ke atas [⎋]</span>.
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="step-num">3</div>
                    <div class="step-body">
                        Gulir menu ke bawah lalu ketuk <span class="step-highlight">Tambah ke Layar Utama</span> (*Add to Home Screen ➕*).
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="step-num">4</div>
                    <div class="step-body">
                        Ketuk <strong>"Tambah"</strong> (*Add*) di pojok kanan atas layar. Selesai!
                    </div>
                </div>
            </div>
        </div>

        <div class="pwa-benefit-box">
            💡 <strong>Keunggulan Aplikasi Web (PWA):</strong><br>
            • Hemat memori (ukuran sangat kecil & ringan)<br>
            • Tampilan layar penuh persis aplikasi native Play Store<br>
            • Selalu update otomatis dengan warta & persembahan terbaru gereja
        </div>
    </div>
</div>

<!-- Floating PWA Install Bar for Mobile -->
<div id="pwa-floating-bar" class="pwa-floating-bar" style="display:none;">
    <img src="{{ asset('icons/icon-96x96.png') }}" alt="Logo" class="pwa-float-icon">
    <div class="pwa-float-texts">
        <div class="pwa-float-title">GEMINDO Kawan Kasih</div>
        <div class="pwa-float-sub" id="floatBarSub">Download &amp; Pasang Aplikasi (2.7 MB)</div>
    </div>
    <button type="button" class="btn-pwa-float" onclick="openInstallModal()">
        <span>⬇️ Pasang</span>
    </button>
    <button type="button" class="btn-pwa-float-close" onclick="closeFloatingBar()" aria-label="Tutup">✕</button>
</div>

<script>
// Mobile menu toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navMenu = document.getElementById('navMenu');

if (mobileMenuBtn && navMenu) {
    mobileMenuBtn.addEventListener('click', function() {
        navMenu.classList.toggle('open');
    });

    // Close menu when clicking any nav item
    navMenu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
            navMenu.classList.remove('open');
        });
    });
}

// Scroll fade-in animation
const fadeEls = document.querySelectorAll('.fade-up');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('visible'), i * 80);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });
fadeEls.forEach(el => observer.observe(el));

// ── PWA & Install Modal Logic ──
let deferredInstallPrompt = null;

// Service Worker Registration
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('[SW Public] Registered:', reg.scope))
            .catch(err => console.warn('[SW Public] Reg failed:', err));
    });
}

window.addEventListener('beforeinstallprompt', function(e) {
    e.preventDefault();
    deferredInstallPrompt = e;
    const directBox = document.getElementById('directInstallBox');
    if (directBox) directBox.style.display = 'flex';
    const floatBar = document.getElementById('pwa-floating-bar');
    if (floatBar && !sessionStorage.getItem('pwa_float_dismissed')) {
        floatBar.style.display = 'flex';
    }
});

window.addEventListener('appinstalled', function() {
    console.log('[PWA Public] Application installed successfully!');
    closeInstallModal();
    closeFloatingBar();
});

function openInstallModal() {
    var isAndroid = /Android/i.test(navigator.userAgent);

    // Android: langsung download APK tanpa buka modal
    if (isAndroid) {
        downloadApk();
        return;
    }

    // If native prompt is ready, trigger it directly!
    if (deferredInstallPrompt) {
        deferredInstallPrompt.prompt();
        deferredInstallPrompt.userChoice.then(function(choice) {
            if (choice.outcome === 'accepted') {
                console.log('[PWA Public] User accepted install');
                closeInstallModal();
                closeFloatingBar();
            }
            deferredInstallPrompt = null;
        });
        return;
    }

    // Auto-detect OS: if iOS, automatically switch to iOS tab
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    switchInstallTab(isIOS ? 'ios' : 'android');

    const modal = document.getElementById('installModal');
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeInstallModal() {
    const modal = document.getElementById('installModal');
    if (modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('.guide-step-item').forEach(function(el) {
        el.classList.remove('step-pulse');
    });
}

function handleModalBackdropClick(event) {
    if (event.target.id === 'installModal') {
        closeInstallModal();
    }
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeInstallModal();
});

function switchInstallTab(os) {
    const tabAndroid = document.getElementById('tabBtnAndroid');
    const tabIos = document.getElementById('tabBtnIos');
    const guideAndroid = document.getElementById('guideAndroid');
    const guideIos = document.getElementById('guideIos');

    if (!tabAndroid || !tabIos || !guideAndroid || !guideIos) return;

    if (os === 'android') {
        tabAndroid.classList.add('active');
        tabIos.classList.remove('active');
        guideAndroid.style.display = 'block';
        guideIos.style.display = 'none';
    } else {
        tabIos.classList.add('active');
        tabAndroid.classList.remove('active');
        guideIos.style.display = 'block';
        guideAndroid.style.display = 'none';
    }
}

function triggerPwaPrompt() {
    var isAndroid = /Android/i.test(navigator.userAgent);
    var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    if (isAndroid) {
        // Android: langsung download APK
        downloadApk();
        return;
    }

    if (deferredInstallPrompt) {
        deferredInstallPrompt.prompt();
        deferredInstallPrompt.userChoice.then(function(choice) {
            if (choice.outcome === 'accepted') {
                console.log('[PWA Public] User accepted install');
                closeInstallModal();
                closeFloatingBar();
            }
            deferredInstallPrompt = null;
        });
    } else {
        showInstallGuideTip();
    }
}

function downloadApk() {
    var apkUrl = '/downloads/gemindo-kk.apk';
    var a = document.createElement('a');
    a.href = apkUrl;
    a.download = 'GEMINDO-Kawan-Kasih.apk';
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    // Tampilkan pesan panduan instalasi APK
    var notice = document.getElementById('installStatusNotice');
    if (notice) {
        notice.className = 'install-action-tip';
        notice.style.display = 'block';
        notice.innerHTML = '✅ <strong>APK sedang diunduh!</strong><br>' +
            'Setelah selesai, buka file <strong>GEMINDO-Kawan-Kasih.apk</strong> dari notifikasi unduhan, ' +
            'lalu ketuk <strong>"Instal"</strong>. Jika muncul peringatan, izinkan <em>"Instal aplikasi dari sumber tidak dikenal"</em> di Pengaturan.';
    }
}

function showInstallGuideTip() {
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const notice = document.getElementById('installStatusNotice');
    if (isIOS) {
        switchInstallTab('ios');
        if (notice) {
            notice.className = 'install-action-tip';
            notice.style.display = 'block';
            notice.innerHTML = '👉 <strong>Langkah untuk iPhone (Safari):</strong><br>Ketuk tombol <strong>Share / Bagikan [⎋]</strong> di bilah bawah browser Safari Anda, lalu gulir dan pilih <strong>"Tambah ke Layar Utama" (➕)</strong>.';
        }
        document.querySelectorAll('#guideIos .guide-step-item').forEach(function(el) {
            el.classList.add('step-pulse');
        });
    } else {
        switchInstallTab('android');
        if (notice) {
            notice.className = 'install-action-tip';
            notice.style.display = 'block';
            notice.innerHTML = '👉 <strong>Langkah untuk Android (Chrome):</strong><br>Ketuk ikon <strong>titik tiga (⋮)</strong> di pojok kanan atas browser Chrome, lalu pilih menu <strong>"Instal aplikasi"</strong> atau <strong>"Tambahkan ke Layar utama"</strong>.';
        }
        document.querySelectorAll('#guideAndroid .guide-step-item').forEach(function(el) {
            el.classList.add('step-pulse');
        });
    }
}

function initFloatingBar() {
    try {
        const isDismissed = sessionStorage.getItem('pwa_float_dismissed');
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;
        if (!isDismissed && !isStandalone) {
            setTimeout(function() {
                const bar = document.getElementById('pwa-floating-bar');
                if (bar) bar.style.display = 'flex';
            }, 1200);
        }
    } catch (e) {}
}

function closeFloatingBar() {
    const bar = document.getElementById('pwa-floating-bar');
    if (bar) bar.style.display = 'none';
    try { sessionStorage.setItem('pwa_float_dismissed', '1'); } catch(e) {}
}

window.addEventListener('load', function() {
    initFloatingBar();
});
</script>
</body>
</html>
