<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – GEMINDO Kawan Kasih</title>
    <meta name="description" content="Portal Jemaat GEMINDO Kawan Kasih">
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* Spiritual color palette */
            --primary:        #2c1810;   /* Deep mahogany */
            --primary-light:  #3d2317;   /* Rich brown */
            --primary-dark:   #1a0e09;   /* Dark wood */
            --accent:         #c8941a;   /* Sacred gold */
            --accent-light:   #e8b84b;   /* Light gold */
            --accent-dark:    #a07614;   /* Deep gold */
            --burgundy:       #6b1a2e;   /* Liturgical burgundy */
            --parchment:      #fdf6e3;   /* Warm parchment */
            --cream:          #faf3e0;   /* Light cream */
            --success:        #2d6a4f;   /* Forest green */
            --danger:         #8b1a1a;   /* Deep red */
            --warning:        #b8601a;   /* Amber */
            --info:           #1a4a6b;   /* Deep blue */
            --bg:             #f5ede0;   /* Warm parchment bg */
            --card:           #fffcf5;   /* Cream white */
            --border:         #e8d9c0;   /* Warm border */
            --text:           #2c1810;   /* Dark mahogany text */
            --text-muted:     #7a5c42;   /* Warm muted */
            --text-light:     #b09070;   /* Light warm */
            --sidebar-w:      270px;
            --header-h:       64px;
            --radius:         10px;
            --shadow:         0 2px 8px rgba(44,24,16,.10);
            --shadow-md:      0 6px 20px rgba(44,24,16,.15);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            background-image:
                radial-gradient(circle at 20% 50%, rgba(200,148,26,.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(107,26,46,.03) 0%, transparent 40%);
            color: var(--text);
            min-height: 100vh;
            min-height: 100dvh;
            overflow-x: hidden;
        }

        /* ====== SIDEBAR ====== */
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w);
            height: 100vh; height: 100dvh; display: flex; flex-direction: column;
            z-index: 200; transition: transform .3s ease;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 40%, #3d1a10 100%);
            box-shadow: 4px 0 24px rgba(0,0,0,.25);
            overflow: hidden;
        }
        /* Subtle cross watermark in sidebar */
        .sidebar::before {
            content: '✝';
            position: absolute; bottom: 80px; right: -10px;
            font-size: 160px; color: rgba(255,255,255,.02);
            font-family: 'Cinzel', serif; pointer-events: none;
            line-height: 1;
        }

        .sidebar-brand {
            padding: 18px 20px 16px;
            border-bottom: 1px solid rgba(200,148,26,.2);
            flex-shrink: 0;
            background: rgba(0,0,0,.18);
            position: relative;
        }
        .sidebar-brand-inner {
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand-logo {
            width: 38px; height: 46px; object-fit: contain;
            flex-shrink: 0; filter: drop-shadow(0 2px 8px rgba(0,0,0,.4));
        }
        .sidebar-brand-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 14.5px; font-weight: 800; color: #fff;
            line-height: 1.25; letter-spacing: -0.01em;
        }
        .sidebar-brand-sub {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 10.5px; font-weight: 700; color: var(--accent-light);
            letter-spacing: .08em; text-transform: uppercase;
            margin-top: 3px; opacity: .9;
        }

        /* Daily verse strip */
        .sidebar-verse {
            padding: 10px 18px;
            border-bottom: 1px solid rgba(200,148,26,.15);
            background: rgba(200,148,26,.06);
            flex-shrink: 0;
        }
        .sidebar-verse p {
            font-family: 'EB Garamond', Georgia, serif;
            font-size: 12.5px; color: rgba(255,255,255,.7);
            font-style: italic; line-height: 1.5;
        }
        .sidebar-verse cite {
            font-size: 10.5px; color: var(--accent-light); opacity: .85;
            font-style: normal; letter-spacing: .05em; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
            padding: 10px 0;
        }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(200,148,26,.2); border-radius: 2px; }

        .nav-section-title {
            font-size: 9.5px; font-weight: 600; color: rgba(200,148,26,.6);
            text-transform: uppercase; letter-spacing: .12em;
            padding: 14px 22px 5px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 22px; color: rgba(255,255,255,.7); text-decoration: none;
            font-size: 13.5px; font-weight: 500;
            transition: all .2s ease; position: relative;
        }
        .nav-link:hover { color: #fff; background: rgba(200,148,26,.1); }
        .nav-link.active {
            color: var(--accent-light);
            background: linear-gradient(90deg, rgba(200,148,26,.18), rgba(200,148,26,.04));
            border-left: 3px solid var(--accent);
        }
        .nav-link .nav-icon { width: 17px; height: 17px; flex-shrink: 0; opacity: .75; }
        .nav-link.active .nav-icon { opacity: 1; color: var(--accent-light); }
        .nav-link:hover .nav-icon { opacity: 1; }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid rgba(200,148,26,.2);
            flex-shrink: 0;
            background: rgba(0,0,0,.2);
            padding-bottom: max(14px, env(safe-area-inset-bottom, 14px));
        }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            color: var(--primary-dark);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(200,148,26,.4);
        }
        .user-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: #fff; line-height: 1.3; }
        .user-role {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10.5px; font-weight: 600; color: var(--accent-light); opacity: .85;
            text-transform: uppercase; letter-spacing: .05em;
        }
        .btn-logout {
            display: flex; align-items: center; gap: 8px; width: 100%;
            padding: 8px 12px;
            background: rgba(139,26,26,.2); border: 1px solid rgba(139,26,26,.35);
            color: #ffaaaa; border-radius: 7px; font-size: 12.5px; cursor: pointer;
            transition: all .2s ease; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;
        }
        .btn-logout:hover { background: rgba(139,26,26,.4); color: #fff; }

        /* ====== TOP HEADER ====== */
        .top-header {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--header-h);
            background: var(--card);
            border-bottom: 2px solid var(--border);
            display: flex; align-items: center; padding: 0 28px;
            z-index: 100; gap: 14px;
            box-shadow: 0 2px 12px rgba(44,24,16,.08);
        }
        /* Gold gradient line at top of header */
        .top-header::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
        }
        .hamburger { display: none; background: none; border: none; cursor: pointer; padding: 4px; flex-shrink: 0; }
        .hamburger span { display: block; width: 20px; height: 2px; background: var(--text); margin: 4px 0; border-radius: 2px; transition: .3s; }
        .header-logo-wrap { display: none; align-items: center; flex-shrink: 0; margin-right: 2px; }
        .header-logo-img { width: 28px; height: 34px; object-fit: contain; }
        @media (max-width: 768px) { .header-logo-wrap { display: flex; } }
        .header-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 16px; font-weight: 700; flex: 1;
            color: var(--primary); letter-spacing: -0.01em;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .header-right { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }

        /* ====== MAIN CONTENT ====== */
        .main-content {
            margin-left: var(--sidebar-w);
            padding-top: var(--header-h);
            min-height: 100vh;
            min-height: 100dvh;
            max-width: 100%;
            overflow-x: hidden;
        }
        .page-body {
            padding: 28px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        /* ====== CARDS ====== */
        .card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: relative;
            max-width: 100%;
        }
        .card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
            opacity: 0; transition: opacity .3s;
            border-radius: var(--radius) var(--radius) 0 0;
        }
        .card:hover::before { opacity: 1; }
        .card-header {
            padding: 18px 22px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: linear-gradient(135deg, rgba(200,148,26,.04), transparent);
            flex-wrap: wrap;
        }
        .card-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 15.5px; font-weight: 700; color: var(--primary);
            letter-spacing: -0.01em;
        }
        .card-body { padding: 22px; max-width: 100%; }

        /* ====== STAT CARDS ====== */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 20px;
            display: flex; align-items: flex-start; gap: 14px;
            box-shadow: var(--shadow); transition: all .25s ease;
            position: relative; overflow: hidden;
            min-width: 0;
        }
        .stat-card > div:last-child {
            min-width: 0;
            flex: 1;
        }
        .stat-card::after {
            content: ''; position: absolute;
            bottom: -15px; right: -15px;
            width: 60px; height: 60px;
            background: rgba(200,148,26,.05);
            border-radius: 50%;
        }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 20px;
        }
        .stat-icon.blue    { background: #e8f0f8; color: #1a4a6b; }
        .stat-icon.gold    { background: #fef5dc; color: var(--accent-dark); }
        .stat-icon.green   { background: #e8f5ee; color: var(--success); }
        .stat-icon.red     { background: #f8e8e8; color: var(--danger); }
        .stat-icon.purple  { background: #f0e8f5; color: #5a1a7a; }
        .stat-icon.burgundy{ background: #f5e8ed; color: var(--burgundy); }
        .stat-value {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: clamp(18px, 3.2vw, 24px);
            font-weight: 800; color: var(--primary);
            line-height: 1.15; margin-bottom: 5px;
            word-break: break-word;
            overflow-wrap: break-word;
            font-variant-numeric: tabular-nums;
        }
        .stat-label { font-size: 12.5px; color: var(--text-muted); font-style: italic; }

        /* ====== TABLE ====== */
        .table-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: linear-gradient(135deg, #f5ede0, #fdf6e3);
            font-size: 11.5px; font-weight: 700; color: var(--accent-dark);
            text-transform: uppercase; letter-spacing: .05em;
            padding: 11px 16px; text-align: left;
            border-bottom: 2px solid var(--border);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(200,148,26,.04); }

        /* ====== BADGES ====== */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; }
        .badge-success  { background: #e8f5ee; color: #2d6a4f; }
        .badge-danger   { background: #f8e8e8; color: #8b1a1a; }
        .badge-warning  { background: #fef0d8; color: #8b4a0a; }
        .badge-info     { background: #e8f0f8; color: #1a4a6b; }
        .badge-secondary{ background: #f5ede0; color: var(--text-muted); }
        .badge-gold     { background: #fef5dc; color: var(--accent-dark); border: 1px solid rgba(200,148,26,.2); }

        /* ====== BUTTONS ====== */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 7px;
            font-size: 13.5px; font-weight: 600; cursor: pointer; border: none;
            text-decoration: none; transition: all .2s ease;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
        .btn-sm { padding: 6px 13px; font-size: 12.5px; }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-dark));
            color: #fff;
            box-shadow: 0 2px 8px rgba(44,24,16,.25);
        }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 4px 12px rgba(44,24,16,.3); }
        .btn-accent {
            background: linear-gradient(135deg, var(--accent-light), var(--accent-dark));
            color: var(--primary-dark);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(200,148,26,.3);
        }
        .btn-accent:hover { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); box-shadow: 0 4px 12px rgba(200,148,26,.4); }
        .btn-success { background: linear-gradient(135deg, #3d8b5f, var(--success)); color: #fff; }
        .btn-success:hover { background: var(--success); }
        .btn-danger  { background: linear-gradient(135deg, #a33, var(--danger)); color: #fff; }
        .btn-danger:hover  { background: var(--danger); }
        .btn-outline {
            background: transparent; border: 1.5px solid var(--border);
            color: var(--text-muted);
        }
        .btn-outline:hover { border-color: var(--accent); color: var(--primary); background: rgba(200,148,26,.05); }
        .btn-warning { background: linear-gradient(135deg, #d4821a, var(--warning)); color: #fff; }
        .btn-warning:hover { background: var(--warning); }

        /* ====== FORMS ====== */
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--text); margin-bottom: 6px; letter-spacing: .02em; font-family: 'Plus Jakarta Sans', sans-serif; }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 7px; font-size: 13.5px;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            color: var(--text); background: var(--card);
            transition: all .2s; outline: none;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(200,148,26,.12); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: 12px; margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif; }
        select.form-control { cursor: pointer; }

        /* ====== ALERTS ====== */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; border-left: 4px solid; font-family: 'Plus Jakarta Sans', sans-serif; }
        .alert-success { background: #e8f5ee; border-color: var(--success); color: #2d6a4f; }
        .alert-danger  { background: #f8e8e8; border-color: var(--danger); color: #8b1a1a; }
        .alert-warning { background: #fef0d8; border-color: var(--warning); color: #8b4a0a; }
        .alert-info    { background: #e8f0f8; border-color: var(--info); color: #1a4a6b; }

        /* ====== VERSE CALLOUT (spiritual element) ====== */
        .verse-card {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-radius: var(--radius); padding: 20px 24px;
            border: 1px solid rgba(200,148,26,.3);
            position: relative; overflow: hidden;
            margin-bottom: 24px;
        }
        .verse-card::before {
            content: '"'; position: absolute;
            top: -20px; left: 10px; font-size: 120px;
            font-family: 'EB Garamond', serif; color: rgba(200,148,26,.12);
            line-height: 1; pointer-events: none;
        }
        .verse-card p {
            font-family: 'EB Garamond', serif; font-size: 17px;
            color: rgba(255,255,255,.9); font-style: italic; line-height: 1.7;
            margin-bottom: 8px; position: relative;
        }
        .verse-card cite { font-size: 12px; color: var(--accent-light); font-style: normal; letter-spacing: .05em; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; }

        /* ====== PAGE HEADER ====== */
        .page-header { margin-bottom: 24px; }
        .page-header-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 22px; font-weight: 800;
            color: var(--primary); margin-bottom: 4px;
            letter-spacing: -0.02em;
        }
        .page-header-title::after {
            content: '';
            display: block; width: 40px; height: 2.5px;
            background: linear-gradient(90deg, var(--accent), transparent);
            margin-top: 6px; border-radius: 2px;
        }
        .breadcrumb { font-size: 12.5px; color: var(--text-muted); }
        .breadcrumb a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb a:hover { color: var(--accent-dark); }

        /* ====== PAGINATION ====== */
        .pagination-wrapper { margin-top: 20px; }
        .pagination-wrapper .pagination { display: flex; gap: 4px; flex-wrap: wrap; }
        .pagination-wrapper .page-item .page-link {
            padding: 6px 13px; border-radius: 6px; font-size: 13px;
            border: 1.5px solid var(--border); color: var(--text-muted);
            text-decoration: none; transition: all .2s;
            background: var(--card);
        }
        .pagination-wrapper .page-item.active .page-link {
            background: var(--accent); border-color: var(--accent); color: #fff;
        }
        .pagination-wrapper .page-item .page-link:hover {
            border-color: var(--accent); color: var(--accent-dark);
            background: rgba(200,148,26,.08);
        }

        /* ====== MOBILE & RESPONSIVE ARCHITECTURE ====== */
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 150; backdrop-filter: blur(2px); }

        /* Table Scroll Hint (default hidden on desktop) */
        .table-scroll-hint { display: none; }

        @media (max-width: 768px) {
            html, body { overflow-x: hidden !important; max-width: 100vw !important; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .top-header { left: 0; padding: 0 14px; }
            
            /* Sediakan padding bawah yang luas agar konten TIDAK PERNAH tertutup bottom navigation bar */
            .main-content {
                margin-left: 0;
                padding-bottom: calc(100px + env(safe-area-inset-bottom, 20px)) !important;
                overflow-x: hidden;
            }
            .hamburger { display: block; }
            .page-body {
                padding: 14px 12px 30px;
                max-width: 100%;
                overflow-x: hidden;
            }
            
            /* Responsive Stat Cards: Modern 2-column grid on mobile */
            .stat-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-bottom: 16px;
            }
            .stat-grid > .stat-card:nth-child(odd):last-child {
                grid-column: span 2;
            }
            .stat-card {
                padding: 14px 12px;
                gap: 10px;
                border-radius: 12px;
            }
            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
                border-radius: 8px;
            }
            .stat-value {
                font-size: clamp(16px, 4.5vw, 22px);
                margin-bottom: 2px;
            }
            .stat-label {
                font-size: 11px;
                line-height: 1.25;
            }

            .page-header-title { font-size: 18px; }
            
            /* Action buttons row wraps nicely */
            .d-flex.gap-2, .d-flex.gap-3 { flex-wrap: wrap; }
            
            /* Header right hides secondary text on mobile */
            .header-right .btn-outline span.hide-mobile { display: none; }
            
            /* Card body & header touch-friendly padding */
            .card {
                border-radius: 12px;
                margin-bottom: 16px;
            }
            .card-body { padding: 14px; }
            .card-header { padding: 12px 14px; gap: 8px; }
            .card-title { font-size: 14.5px; }

            /* ── MOBILE TABLE CARD-TRANSFORMATION (.table-responsive-stack & all tables in wrapper) ── */
            /* Setiap baris tabel berubah menjadi kartu mobile tersendiri sehingga kolom tidak terpotong */
            .table-responsive-stack,
            table.table-responsive-stack,
            .table-wrapper table,
            .card-body > table,
            .card-body .table-wrapper > table {
                width: 100% !important;
                overflow: visible !important;
            }
            .table-responsive-stack table,
            table.table-responsive-stack,
            .table-wrapper table,
            .table-responsive-stack thead,
            table.table-responsive-stack thead,
            .table-wrapper table thead,
            .table-responsive-stack tbody,
            table.table-responsive-stack tbody,
            .table-wrapper table tbody,
            .table-responsive-stack th,
            table.table-responsive-stack th,
            .table-wrapper table th,
            .table-responsive-stack td,
            table.table-responsive-stack td,
            .table-wrapper table td,
            .table-responsive-stack tr,
            table.table-responsive-stack tr,
            .table-wrapper table tr {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            .table-responsive-stack thead,
            table.table-responsive-stack thead,
            .table-wrapper table thead {
                display: none !important;
            }
            .table-responsive-stack tbody tr,
            table.table-responsive-stack tbody tr,
            .table-wrapper table tbody tr {
                background: var(--card);
                border: 1px solid var(--border);
                border-radius: 12px;
                padding: 14px;
                margin-bottom: 12px;
                box-shadow: 0 2px 8px rgba(44,24,16,.05);
                position: relative;
                overflow: hidden !important;
                max-width: 100% !important;
            }
            .table-responsive-stack tbody tr:hover,
            table.table-responsive-stack tbody tr:hover,
            .table-wrapper table tbody tr:hover {
                background: var(--card);
            }
            .table-responsive-stack td,
            table.table-responsive-stack td,
            .table-wrapper table td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 8px 0 !important;
                border-bottom: 1px solid rgba(232, 217, 192, 0.4) !important;
                font-size: 12.5px !important;
                text-align: right !important;
                gap: 12px;
                min-width: 0 !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }
            .table-responsive-stack td > *,
            table.table-responsive-stack td > *,
            .table-wrapper table td > * {
                min-width: 0 !important;
                max-width: 100% !important;
                overflow-wrap: anywhere !important;
                word-break: break-word;
            }
            .table-responsive-stack td:last-child,
            table.table-responsive-stack td:last-child,
            .table-wrapper table td:last-child {
                border-bottom: none !important;
                padding-top: 10px !important;
                margin-top: 6px !important;
                border-top: 1px dashed rgba(200, 148, 26, 0.25) !important;
                justify-content: stretch !important;
            }
            .table-responsive-stack td::before,
            table.table-responsive-stack td::before,
            .table-wrapper table td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--accent-dark);
                font-size: 10.5px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                text-align: left;
                flex-shrink: 0;
            }
            /* Highlight title row on card */
            .table-responsive-stack td.cell-title,
            table.table-responsive-stack td.cell-title,
            .table-wrapper table td.cell-title,
            .table-responsive-stack td[data-label="Nama Ibadah"],
            table.table-responsive-stack td[data-label="Nama Ibadah"],
            .table-wrapper table td[data-label="Nama Ibadah"],
            .table-responsive-stack td[data-label="Ibadah"],
            table.table-responsive-stack td[data-label="Ibadah"],
            .table-wrapper table td[data-label="Ibadah"],
            .table-responsive-stack td[data-label="Donatur"],
            table.table-responsive-stack td[data-label="Donatur"],
            .table-wrapper table td[data-label="Donatur"],
            .table-responsive-stack td[data-label="Nama Pengguna"],
            table.table-responsive-stack td[data-label="Nama Pengguna"],
            .table-wrapper table td[data-label="Nama Pengguna"],
            .table-responsive-stack td[data-label="Nama Lengkap"],
            table.table-responsive-stack td[data-label="Nama Lengkap"],
            .table-wrapper table td[data-label="Nama Lengkap"],
            .table-responsive-stack td[data-label="Nama"],
            table.table-responsive-stack td[data-label="Nama"],
            .table-wrapper table td[data-label="Nama"],
            .table-responsive-stack td[data-label="Judul Pengumuman"],
            table.table-responsive-stack td[data-label="Judul Pengumuman"],
            .table-wrapper table td[data-label="Judul Pengumuman"],
            .table-responsive-stack td[data-label="Nama Kegiatan"],
            table.table-responsive-stack td[data-label="Nama Kegiatan"],
            .table-wrapper table td[data-label="Nama Kegiatan"] {
                flex-direction: column !important;
                align-items: flex-start !important;
                text-align: left !important;
                border-bottom: 1.5px solid var(--border) !important;
                padding-bottom: 10px !important;
                margin-bottom: 4px !important;
            }
            .table-responsive-stack td.cell-title::before,
            table.table-responsive-stack td.cell-title::before,
            .table-wrapper table td.cell-title::before,
            .table-responsive-stack td[data-label="Nama Ibadah"]::before,
            table.table-responsive-stack td[data-label="Nama Ibadah"]::before,
            .table-responsive-stack td[data-label="Ibadah"]::before,
            table.table-responsive-stack td[data-label="Ibadah"]::before,
            .table-responsive-stack td[data-label="Donatur"]::before,
            table.table-responsive-stack td[data-label="Donatur"]::before,
            .table-responsive-stack td[data-label="Nama Pengguna"]::before,
            table.table-responsive-stack td[data-label="Nama Pengguna"]::before,
            .table-responsive-stack td[data-label="Nama Lengkap"]::before,
            table.table-responsive-stack td[data-label="Nama Lengkap"]::before,
            .table-responsive-stack td[data-label="Nama"]::before,
            table.table-responsive-stack td[data-label="Nama"]::before,
            .table-responsive-stack td[data-label="Judul Pengumuman"]::before,
            table.table-responsive-stack td[data-label="Judul Pengumuman"]::before,
            .table-responsive-stack td[data-label="Nama Kegiatan"]::before,
            table.table-responsive-stack td[data-label="Nama Kegiatan"]::before {
                margin-bottom: 3px;
            }

            /* Email / Contact / Multiline / Notes cell: stack vertically to prevent ANY overflow */
            .table-responsive-stack td[data-label*="Kontak"],
            table.table-responsive-stack td[data-label*="Kontak"],
            .table-wrapper table td[data-label*="Kontak"],
            .table-responsive-stack td[data-label*="Email"],
            table.table-responsive-stack td[data-label*="Email"],
            .table-wrapper table td[data-label*="Email"],
            .table-responsive-stack td[data-label*="Catatan"],
            table.table-responsive-stack td[data-label*="Catatan"],
            .table-wrapper table td[data-label*="Catatan"],
            .table-responsive-stack td[data-label*="Keterangan"],
            table.table-responsive-stack td[data-label*="Keterangan"],
            .table-wrapper table td[data-label*="Keterangan"],
            .table-responsive-stack td[data-label*="Alamat"],
            table.table-responsive-stack td[data-label*="Alamat"],
            .table-wrapper table td[data-label*="Alamat"] {
                flex-direction: column !important;
                align-items: flex-start !important;
                text-align: left !important;
                gap: 4px !important;
            }
            .table-responsive-stack td[data-label*="Kontak"] > *,
            table.table-responsive-stack td[data-label*="Kontak"] > *,
            .table-wrapper table td[data-label*="Kontak"] > *,
            .table-responsive-stack td[data-label*="Email"] > *,
            table.table-responsive-stack td[data-label*="Email"] > *,
            .table-wrapper table td[data-label*="Email"] > * {
                text-align: left !important;
                width: 100% !important;
                max-width: 100% !important;
                word-break: break-all !important;
                overflow-wrap: anywhere !important;
            }

            .user-contact-info {
                display: flex;
                flex-direction: column;
                gap: 2px;
                width: 100%;
                text-align: left;
            }
            .user-email-text {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 13px;
                color: var(--primary);
                word-break: break-all !important;
                overflow-wrap: anywhere !important;
                max-width: 100% !important;
            }

            /* Mobile Actions Buttons */
            .table-responsive-stack .table-actions,
            table.table-responsive-stack .table-actions,
            .table-wrapper table .table-actions,
            .table-responsive-stack td:last-child .d-flex,
            table.table-responsive-stack td:last-child .d-flex,
            .table-wrapper table td:last-child .d-flex {
                width: 100%;
                display: flex !important;
                gap: 8px;
            }
            .table-responsive-stack .table-actions .btn,
            table.table-responsive-stack .table-actions .btn,
            .table-wrapper table .table-actions .btn,
            .table-responsive-stack .table-actions form,
            table.table-responsive-stack .table-actions form,
            .table-wrapper table .table-actions form,
            .table-responsive-stack td:last-child .d-flex .btn,
            table.table-responsive-stack td:last-child .d-flex .btn,
            .table-wrapper table td:last-child .d-flex .btn,
            .table-responsive-stack td:last-child .d-flex form,
            table.table-responsive-stack td:last-child .d-flex form,
            .table-wrapper table td:last-child .d-flex form {
                flex: 1;
            }
            .table-responsive-stack .table-actions form .btn,
            table.table-responsive-stack .table-actions form .btn,
            .table-wrapper table .table-actions form .btn,
            .table-responsive-stack td:last-child .d-flex form .btn,
            table.table-responsive-stack td:last-child .d-flex form .btn,
            .table-wrapper table td:last-child .d-flex form .btn {
                width: 100%;
            }
            .table-responsive-stack td:empty,
            table.table-responsive-stack td:empty,
            .table-wrapper table td:empty {
                display: none !important;
            }

            /* Touch-friendly Form Action Buttons on Mobile */
            .form-actions-mobile,
            form .card-footer .d-flex,
            .modal-footer .d-flex {
                flex-direction: column-reverse !important;
                gap: 10px !important;
            }
            .form-actions-mobile .btn,
            form .card-footer .d-flex .btn,
            .modal-footer .d-flex .btn {
                width: 100% !important;
                justify-content: center !important;
                min-height: 42px;
            }

            /* GLOBAL: Prevent any table from causing horizontal scroll */
            .table-wrapper {
                overflow-x: hidden !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .table-wrapper > table,
            .table-wrapper > table * {
                max-width: 100%;
                word-break: break-word;
                overflow-wrap: break-word;
            }

            /* Prevent content overflow in cards */
            .card-body { overflow: hidden; }
            .card-body img { max-width: 100%; height: auto; }

            /* Grid fixes: stack 2-col and 3-col grids on mobile */
            .grid-2, .grid-3 {
                grid-template-columns: 1fr !important;
                gap: 14px;
            }

            /* Quick admin buttons wrap nicely */
            .quick-admin-btns {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 10px !important;
            }
            .quick-admin-btns .btn {
                flex: 1 1 140px !important;
                min-width: 120px !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 480px) {
            html, body { overflow-x: hidden !important; max-width: 100vw !important; }
            .stat-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .stat-card {
                padding: 10px 10px;
                gap: 8px;
            }
            .stat-icon {
                width: 34px;
                height: 34px;
                font-size: 15px;
            }
            .top-header { padding: 0 10px; }
            .header-title { font-size: 13.5px; }
            .badge { padding: 2px 7px; font-size: 10px; }
            .btn { min-height: 40px; }
            .btn-sm { min-height: 36px; padding: 6px 10px; }
            /* Extra safety: all table-wrappers never scroll on phones */
            .table-wrapper {
                overflow: hidden !important;
            }
            /* Breadcrumb doesn't overflow */
            .breadcrumb { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%; }
        }

        /* ====== MOBILE BOTTOM NAV ====== */
        .mobile-bottom-nav {
            display: none;
            position: fixed; bottom: 0; left: 0; right: 0;
            height: calc(60px + env(safe-area-inset-bottom, 0px));
            z-index: 300;
            background: linear-gradient(180deg, var(--primary-dark), var(--primary));
            border-top: 1px solid rgba(200,148,26,.25);
            box-shadow: 0 -4px 20px rgba(0,0,0,.35);
            padding: 0 6px;
            padding-bottom: env(safe-area-inset-bottom, 0px);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .mobile-bottom-nav-inner {
            display: flex; align-items: center; justify-content: space-around;
            height: 100%; gap: 0;
        }
        .mob-nav-item {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 2px;
            padding: 5px 8px; border-radius: 8px;
            text-decoration: none; color: rgba(255,255,255,.6);
            font-size: 10px; font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; letter-spacing: .01em;
            transition: all .2s ease; flex: 1;
            min-height: 48px;
        }
        .mob-nav-item:hover, .mob-nav-item.active {
            color: var(--accent-light);
            background: rgba(200,148,26,.12);
        }
        .mob-nav-item svg { width: 19px; height: 19px; flex-shrink: 0; }
        .mob-nav-item.mob-menu-btn { cursor: pointer; background: none; border: none; font-family: inherit; }
        @media (max-width: 768px) {
            .mobile-bottom-nav { display: block; }
        }

        /* ====== UTILITIES ====== */
        .text-muted   { color: var(--text-muted); }
        .text-success { color: var(--success); }
        .text-danger  { color: var(--danger); }
        .text-warning { color: var(--warning); }
        .fw-bold      { font-weight: 700; }
        .fw-semibold  { font-weight: 600; }
        .small        { font-size: 12px; }
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 8px; }
        .mb-2 { margin-bottom: 16px; }
        .mb-3 { margin-bottom: 24px; }
        .mb-4 { margin-bottom: 32px; }
        .mt-2 { margin-top: 16px; }
        .mt-3 { margin-top: 24px; }
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-content-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .w-100 { width: 100%; }
        .text-end    { text-align: right; }
        .text-center { text-align: center; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
        .grid-2 > *, .grid-3 > * { min-width: 0; }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        .dashboard-grid > * { min-width: 0; }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .min-w-0 { min-width: 0; }
        .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(200,148,26,.3);
        }

        @media (max-width: 1100px) {
            .dashboard-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 960px) {
            .grid-3 { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .grid-2 > *, .grid-3 > * {
                grid-column: span 1 !important;
            }
        }
        /* safe area for iPhone notch */
        @supports (padding-top: env(safe-area-inset-top)) {
            .top-header { padding-top: env(safe-area-inset-top); }
        }

        @yield('styles')
    </style>
    @yield('head')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="sidebar-brand-inner" style="text-decoration:none;">
            <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="sidebar-brand-logo">
            <div>
                <div class="sidebar-brand-title">GEMINDO Kawan Kasih</div>
                <div class="sidebar-brand-sub">Portal Jemaat</div>
            </div>
        </a>
    </div>

    <!-- Daily verse -->
    <div class="sidebar-verse">
        <p>"Kasihilah Tuhan, Allahmu, dengan segenap hatimu."</p>
        <cite>— Matius 22:37</cite>
    </div>

    <nav class="sidebar-nav">
        <!-- Semua User -->
        <div class="nav-section-title">✦ Beranda</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('persembahan.index') }}" class="nav-link {{ request()->routeIs('persembahan.index') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Persembahan Online
        </a>
        <a href="{{ route('jemaat.data-jemaat') }}" class="nav-link {{ request()->routeIs('jemaat.data-jemaat') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Data Jemaat
        </a>

        @auth
        <!-- Jemaat -->
        <div class="nav-section-title">✦ Akun Saya</div>
        <a href="{{ route('jemaat.profil') }}" class="nav-link {{ request()->routeIs('jemaat.profil*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profil Saya
        </a>
        <a href="{{ route('jemaat.riwayat-persembahan') }}" class="nav-link {{ request()->routeIs('jemaat.riwayat*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Riwayat Persembahan
        </a>
        <a href="{{ route('jemaat.kartu') }}" class="nav-link">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
            Kartu Jemaat
        </a>

        @hasanyrole('super_admin|majelis|sekretaris_majelis')
        <!-- Pelayanan Majelis -->
        <div class="nav-section-title">✦ Pelayanan Majelis</div>
        <a href="{{ route('majelis.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('majelis.pendaftaran*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Pendaftaran Jemaat
        </a>
        <a href="{{ route('majelis.jadwal.index') }}" class="nav-link {{ request()->routeIs('majelis.jadwal*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Jadwal Ibadah
        </a>
        <a href="{{ route('majelis.pengumuman.index') }}" class="nav-link {{ request()->routeIs('majelis.pengumuman*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Warta Jemaat
            <span class="badge badge-gold" style="font-size: 9px; padding: 1px 6px; margin-left: auto;">Publik</span>
        </a>
        @endhasanyrole

        @hasanyrole('super_admin|majelis|sekretaris_majelis|pengurus_kategorial|pengurus_kategorial_kpb|pengurus_kategorial_kpw|pengurus_kategorial_kpp|pengurus_kategorial_kpr|pengurus_kategorial_kpa')
        <!-- Publikasi & Kehadiran -->
        <div class="nav-section-title">✦ Pelayanan Jemaat</div>
        <a href="{{ route('majelis.kehadiran.index') }}" class="nav-link {{ request()->routeIs('majelis.kehadiran*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Kehadiran Ibadah
        </a>
        <a href="{{ route('majelis.pengumuman.index') }}" class="nav-link {{ request()->routeIs('majelis.pengumuman*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            Pengumuman
        </a>
        <a href="{{ route('kegiatan.index') }}" class="nav-link {{ request()->routeIs('kegiatan*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Kegiatan KPK
        </a>
        @endhasanyrole

        @hasanyrole('super_admin|majelis|bendahara_majelis')
        <!-- Keuangan Majelis -->
        <div class="nav-section-title">✦ Keuangan Majelis</div>
        <a href="{{ route('majelis.laporan') }}" class="nav-link {{ request()->routeIs('majelis.laporan') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Laporan Keuangan
        </a>
        <a href="{{ route('majelis.persembahan-offline.index') }}" class="nav-link {{ request()->routeIs('majelis.persembahan-offline*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Persembahan Offline
        </a>
        <a href="{{ route('majelis.jenis-persembahan.index') }}" class="nav-link {{ request()->routeIs('majelis.jenis-persembahan*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Kategori Persembahan
        </a>
        @endhasanyrole

        @if(auth()->user()->hasRole('super_admin'))
        <!-- Admin -->
        <div class="nav-section-title">✦ Administrasi</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Manajemen User
        </a>
        <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Approval Pendaftaran
        </a>
        <a href="{{ route('admin.keuangan') }}" class="nav-link {{ request()->routeIs('admin.keuangan*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Laporan Keuangan
        </a>
        <a href="{{ route('admin.pengaturan') }}" class="nav-link {{ request()->routeIs('admin.pengaturan*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pengaturan Aplikasi
        </a>
        @endif
        @endauth
    </nav>

    <div class="sidebar-footer">
        @auth
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nama_display, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->nama_display }}</div>
                <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Jemaat' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
        @endauth
    </div>
</aside>

<!-- TOP HEADER -->
<header class="top-header">
    <button class="hamburger" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
    </button>
    <div class="header-logo-wrap">
        <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="header-logo-img">
    </div>
    <div class="header-title">@yield('header-title', 'Dashboard')</div>
    <div class="header-right">
        <a href="{{ route('home') }}" class="btn btn-outline btn-sm" style="font-size:12px;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span class="hide-mobile">Halaman Publik</span>
        </a>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="main-content">
    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">✕ {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">ℹ {{ session('info') }}</div>
        @endif

        @yield('content')
    </div>
</main>

<!-- MOBILE BOTTOM NAV -->
<nav class="mobile-bottom-nav" id="mobileBottomNav">
    <div class="mobile-bottom-nav-inner">
        <a href="{{ route('dashboard') }}" class="mob-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('persembahan.index') }}" class="mob-nav-item {{ request()->routeIs('persembahan.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Persembahan
        </a>
        @auth
        <a href="{{ route('jemaat.profil') }}" class="mob-nav-item {{ request()->routeIs('jemaat.profil*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profil
        </a>
        @endauth
        <button class="mob-nav-item mob-menu-btn" onclick="toggleSidebar()" aria-label="Menu">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            Menu
        </button>
    </div>
</nav>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('open');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('open');
}
// Close sidebar when nav link clicked on mobile
document.querySelectorAll('.sidebar .nav-link').forEach(function(link) {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) closeSidebar();
    });
});
</script>
@yield('scripts')

{{-- PWA: Install Banner --}}
<div id="pwa-install-banner" style="display:none; position:fixed; bottom:0; left:0; right:0; z-index:9999;
    background: linear-gradient(135deg, #2c1810 0%, #3d2317 100%);
    border-top: 2px solid #c8941a;
    padding: 14px 20px;
    box-shadow: 0 -4px 24px rgba(0,0,0,0.35);
    display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
    <img src="{{ asset('icons/icon-72x72.png') }}" width="44" height="44"
         style="border-radius:10px; border:2px solid #c8941a; flex-shrink:0;" alt="">
    <div style="flex:1; min-width:160px;">
        <div style="color:#e8b84b; font-weight:700; font-size:14px; font-family:'Plus Jakarta Sans',sans-serif;">
            Pasang sebagai Aplikasi
        </div>
        <div style="color:#d4b896; font-size:12px; margin-top:2px; font-family:'Plus Jakarta Sans',sans-serif;">
            Akses GEMINDO KK langsung dari layar utama HP kamu
        </div>
    </div>
    <div style="display:flex; gap:8px; flex-shrink:0;">
        <button id="pwa-install-btn" onclick="pwaInstall()"
            style="background: linear-gradient(135deg, #c8941a, #e8b84b); color:#1a0e09;
                   border:none; padding:9px 18px; border-radius:8px;
                   font-weight:700; font-size:13px; cursor:pointer;
                   font-family:'Plus Jakarta Sans',sans-serif;">
            📲 Install
        </button>
        <button onclick="pwaHideBanner()"
            style="background:transparent; color:#a08070; border:1px solid #5a3a2a;
                   padding:9px 14px; border-radius:8px;
                   font-size:13px; cursor:pointer;">
            ✕
        </button>
    </div>
</div>

<script>
// ── PWA Service Worker Registration ──
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('[SW] Registered, scope:', reg.scope))
            .catch(err => console.warn('[SW] Registration failed:', err));
    });
}

// ── PWA Install Prompt ──
let _pwaPrompt = null;
const _pwaBanner = document.getElementById('pwa-install-banner');

window.addEventListener('beforeinstallprompt', function(e) {
    e.preventDefault();
    _pwaPrompt = e;
    const dismissed = sessionStorage.getItem('pwa-banner-dismissed');
    if (!dismissed && _pwaBanner) {
        _pwaBanner.style.display = 'flex';
    }
});

function pwaInstall() {
    if (!_pwaPrompt) return;
    _pwaPrompt.prompt();
    _pwaPrompt.userChoice.then(function(result) {
        if (result.outcome === 'accepted') {
            pwaHideBanner();
            console.log('[PWA] Installed!');
        }
        _pwaPrompt = null;
    });
}

function pwaHideBanner() {
    if (_pwaBanner) _pwaBanner.style.display = 'none';
    sessionStorage.setItem('pwa-banner-dismissed', '1');
}

// Hide banner if already installed
window.addEventListener('appinstalled', function() {
    pwaHideBanner();
    console.log('[PWA] App installed to home screen.');
});
</script>

</body>
</html>
