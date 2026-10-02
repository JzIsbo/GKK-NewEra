<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – GEMINDO Kawan Kasih</title>
    <meta name="description" content="Portal Jemaat GEMINDO Kawan Kasih">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            background-image:
                radial-gradient(circle at 20% 50%, rgba(200,148,26,.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(107,26,46,.03) 0%, transparent 40%);
            color: var(--text);
            min-height: 100vh;
        }

        /* ====== SIDEBAR ====== */
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w);
            height: 100vh; display: flex; flex-direction: column;
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
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(200,148,26,.2);
            flex-shrink: 0;
            background: rgba(0,0,0,.15);
            position: relative;
        }
        .sidebar-cross-icon {
            display: flex; align-items: center; gap: 12px; margin-bottom: 10px;
        }
        /* SVG Cross */
        .cross-symbol {
            width: 28px; height: 36px; position: relative; flex-shrink: 0;
        }
        .cross-symbol::before {
            content: ''; position: absolute;
            left: 50%; top: 0; transform: translateX(-50%);
            width: 6px; height: 100%;
            background: linear-gradient(180deg, var(--accent-light), var(--accent));
            border-radius: 3px;
        }
        .cross-symbol::after {
            content: ''; position: absolute;
            left: 0; top: 30%;
            width: 100%; height: 6px;
            background: linear-gradient(90deg, var(--accent-light), var(--accent));
            border-radius: 3px;
        }
        .sidebar-brand-title {
            font-family: 'Cinzel', serif;
            font-size: 15px; font-weight: 700; color: #fff;
            line-height: 1.3; letter-spacing: .03em;
        }
        .sidebar-brand-sub {
            font-size: 10px; color: var(--accent-light);
            letter-spacing: .12em; text-transform: uppercase;
            margin-top: 2px; opacity: .9;
        }

        /* Daily verse strip */
        .sidebar-verse {
            padding: 10px 18px;
            border-bottom: 1px solid rgba(200,148,26,.15);
            background: rgba(200,148,26,.06);
            flex-shrink: 0;
        }
        .sidebar-verse p {
            font-family: 'EB Garamond', serif;
            font-size: 11px; color: rgba(255,255,255,.55);
            font-style: italic; line-height: 1.5;
        }
        .sidebar-verse cite {
            font-size: 10px; color: var(--accent-light); opacity: .8;
            font-style: normal; letter-spacing: .05em;
        }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 10px 0; }
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
        .user-name { font-size: 13px; font-weight: 600; color: #fff; line-height: 1.3; }
        .user-role {
            font-size: 10px; color: var(--accent-light); opacity: .8;
            text-transform: capitalize; font-style: italic;
            font-family: 'EB Garamond', serif;
        }
        .btn-logout {
            display: flex; align-items: center; gap: 8px; width: 100%;
            padding: 8px 12px;
            background: rgba(139,26,26,.2); border: 1px solid rgba(139,26,26,.35);
            color: #ffaaaa; border-radius: 7px; font-size: 12.5px; cursor: pointer;
            transition: all .2s ease; font-family: 'Inter', sans-serif; font-weight: 500;
        }
        .btn-logout:hover { background: rgba(139,26,26,.4); color: #fff; }

        /* ====== TOP HEADER ====== */
        .top-header {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--header-h);
            background: var(--card);
            border-bottom: 2px solid var(--border);
            display: flex; align-items: center; padding: 0 28px;
            z-index: 100; gap: 16px;
            box-shadow: 0 2px 12px rgba(44,24,16,.08);
        }
        /* Gold gradient line at top of header */
        .top-header::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
        }
        .hamburger { display: none; background: none; border: none; cursor: pointer; padding: 4px; }
        .hamburger span { display: block; width: 20px; height: 2px; background: var(--text); margin: 4px 0; border-radius: 2px; transition: .3s; }
        .header-title {
            font-family: 'Cinzel', serif;
            font-size: 16px; font-weight: 600; flex: 1;
            color: var(--primary); letter-spacing: .03em;
        }
        .header-right { display: flex; align-items: center; gap: 12px; }

        /* ====== MAIN CONTENT ====== */
        .main-content { margin-left: var(--sidebar-w); padding-top: var(--header-h); min-height: 100vh; }
        .page-body { padding: 28px; }

        /* ====== CARDS ====== */
        .card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: relative; overflow: hidden;
        }
        .card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
            opacity: 0; transition: opacity .3s;
        }
        .card:hover::before { opacity: 1; }
        .card-header {
            padding: 18px 22px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: linear-gradient(135deg, rgba(200,148,26,.04), transparent);
        }
        .card-title {
            font-family: 'Cinzel', serif;
            font-size: 15px; font-weight: 600; color: var(--primary);
            letter-spacing: .02em;
        }
        .card-body { padding: 22px; }

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
            font-family: 'Cinzel', serif;
            font-size: 22px; font-weight: 700; color: var(--primary);
            line-height: 1; margin-bottom: 5px;
        }
        .stat-label { font-size: 12.5px; color: var(--text-muted); font-style: italic; }

        /* ====== TABLE ====== */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: linear-gradient(135deg, #f5ede0, #fdf6e3);
            font-size: 11px; font-weight: 600; color: var(--accent-dark);
            text-transform: uppercase; letter-spacing: .07em;
            padding: 11px 16px; text-align: left;
            border-bottom: 2px solid var(--border);
            font-family: 'Cinzel', serif;
        }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--text); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(200,148,26,.04); }

        /* ====== BADGES ====== */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; }
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
            font-size: 13.5px; font-weight: 500; cursor: pointer; border: none;
            text-decoration: none; transition: all .2s ease;
            font-family: 'Inter', sans-serif;
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
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--text); margin-bottom: 6px; letter-spacing: .02em; }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 7px; font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--text); background: var(--card);
            transition: all .2s; outline: none;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(200,148,26,.12); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: 12px; margin-top: 4px; }
        select.form-control { cursor: pointer; }

        /* ====== ALERTS ====== */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; border-left: 4px solid; }
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
        .verse-card cite { font-size: 12px; color: var(--accent-light); font-style: normal; letter-spacing: .05em; }

        /* ====== PAGE HEADER ====== */
        .page-header { margin-bottom: 24px; }
        .page-header-title {
            font-family: 'Cinzel', serif;
            font-size: 22px; font-weight: 700;
            color: var(--primary); margin-bottom: 4px;
            letter-spacing: .03em;
        }
        .page-header-title::after {
            content: '';
            display: block; width: 40px; height: 2px;
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

        /* ====== MOBILE ====== */
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 150; backdrop-filter: blur(2px); }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .top-header { left: 0; padding: 0 16px; }
            .main-content { margin-left: 0; padding-bottom: 72px; /* room for bottom nav */ }
            .hamburger { display: block; }
            .page-body { padding: 16px 14px; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .page-header-title { font-size: 18px; }
            /* action buttons row wraps on mobile */
            .d-flex.gap-2 { flex-wrap: wrap; }
            /* header right hides text on tiny screens */
            .header-right .btn-outline span.hide-mobile { display: none; }
            /* card body less padding */
            .card-body { padding: 16px; }
            .card-header { padding: 14px 16px; }
            /* table min width to trigger scroll */
            .table-wrapper table { min-width: 560px; }
        }
        @media (max-width: 480px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .top-header { padding: 0 12px; }
            .header-title { font-size: 14px; }
        }
        @media (max-width: 360px) {
            .stat-grid { grid-template-columns: 1fr; }
        }

        /* ====== MOBILE BOTTOM NAV ====== */
        .mobile-bottom-nav {
            display: none;
            position: fixed; bottom: 0; left: 0; right: 0;
            height: 64px; z-index: 300;
            background: linear-gradient(180deg, var(--primary-dark), var(--primary));
            border-top: 1px solid rgba(200,148,26,.25);
            box-shadow: 0 -4px 20px rgba(0,0,0,.3);
            padding: 0 8px;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }
        .mobile-bottom-nav-inner {
            display: flex; align-items: center; justify-content: space-around;
            height: 100%; gap: 0;
        }
        .mob-nav-item {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 3px;
            padding: 6px 12px; border-radius: 10px;
            text-decoration: none; color: rgba(255,255,255,.55);
            font-size: 10px; font-family: 'Inter', sans-serif;
            font-weight: 500; letter-spacing: .02em;
            transition: all .2s ease; flex: 1;
            min-height: 48px;
        }
        .mob-nav-item:hover, .mob-nav-item.active {
            color: var(--accent-light);
            background: rgba(200,148,26,.1);
        }
        .mob-nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }
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
        @media (max-width: 640px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }
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
        <div class="sidebar-cross-icon">
            <div class="cross-symbol"></div>
            <div>
                <div class="sidebar-brand-title">GEMINDO Kawan Kasih</div>
                <div class="sidebar-brand-sub">Portal Jemaat</div>
            </div>
        </div>
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
    <div class="header-title">✝ @yield('header-title', 'Dashboard')</div>
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
</body>
</html>
