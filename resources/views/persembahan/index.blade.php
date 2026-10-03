<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persembahan Online – GEMINDO Kawan Kasih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-gemindo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-gemindo.png') }}">
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
            --danger:        #a22a2a;
            --success:       #2a7a44;
            --radius:        12px;
            --transition:    all 0.3s ease;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-dark);
            background: var(--parchment);
            /* Radial candlelight glow background */
            background-image: 
                radial-gradient(ellipse 60% 40% at 50% 0%, rgba(200, 148, 26, 0.08) 0%, transparent 70%),
                radial-gradient(ellipse 50% 50% at 50% 100%, rgba(107, 26, 46, 0.04) 0%, transparent 70%);
            min-height: 100vh;
            line-height: 1.7;
        }

        .container {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        /* ═══════════════════════════════════════
           HEADER LOGO (Spiritual Theme)
           ═══════════════════════════════════════ */
        .header-logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-warm);
            padding-bottom: 20px;
        }
        
        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }
        
        .header-logo-img {
            width: 44px;
            height: 52px;
            object-fit: contain;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,.25));
        }

        .logo-texts {
            display: flex;
            flex-direction: column;
        }
        .logo-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--mahogany);
            line-height: 1.2;
            letter-spacing: -0.01em;
        }
        .logo-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }
        
        .back-home {
            color: var(--mahogany);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            font-family: 'EB Garamond', serif;
            font-style: italic;
            transition: var(--transition);
        }
        .back-home:hover {
            color: var(--gold-dark);
            text-decoration: underline;
        }

        /* Split Page Layout */
        .split-layout {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 40px;
            align-items: start;
        }
        @media (max-width: 868px) {
            .split-layout { grid-template-columns: 1fr; }
        }

        /* ═══════════════════════════════════════
           CARDS (Sacred Parchment Card)
           ═══════════════════════════════════════ */
        .card {
            background-color: var(--ivory);
            border-radius: var(--radius);
            border: 1px solid var(--border-warm);
            box-shadow: 
                0 10px 30px rgba(44, 24, 16, 0.04),
                0 1px 3px rgba(200, 148, 26, 0.08),
                inset 0 0 40px rgba(250, 240, 215, 0.35);
            overflow: hidden;
            margin-bottom: 30px;
            position: relative;
        }
        
        .card-header {
            padding: 28px 32px;
            border-bottom: 1px solid var(--border-warm);
            background-color: transparent;
            position: relative;
            z-index: 2;
        }
        .card-title {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--mahogany);
            letter-spacing: -0.01em;
        }
        .card-subtitle {
            font-family: 'EB Garamond', serif;
            font-size: 15px;
            color: var(--text-mid);
            margin-top: 4px;
            font-style: italic;
        }
        .card-body {
            padding: 32px;
            position: relative;
            z-index: 2;
        }

        /* Inner border accent inside cards */
        .card::before {
            content: ''; position: absolute;
            top: 10px; left: 10px; right: 10px; bottom: 10px;
            border: 1px solid rgba(200, 148, 26, 0.12);
            border-radius: calc(var(--radius) - 2px);
            pointer-events: none;
            z-index: 1;
        }

        /* ═══════════════════════════════════════
           FORMS & CONTROLS
           ═══════════════════════════════════════ */
        .form-group {
            margin-bottom: 22px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .form-label span { color: var(--danger); }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--border-warm);
            border-radius: 6px;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            outline: none;
            transition: var(--transition);
            background-color: rgba(255, 255, 255, 0.7);
        }
        .form-control:focus {
            border-color: var(--gold);
            background-color: #fff;
            box-shadow: 0 0 8px rgba(200, 148, 26, 0.25);
        }

        /* Quick Nominal Buttons */
        .nominal-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        @media (max-width: 480px) {
            .nominal-options { grid-template-columns: repeat(2, 1fr); }
        }
        .btn-nominal {
            background-color: var(--cream);
            border: 1.5px solid var(--border-warm);
            border-radius: 6px;
            padding: 10px 4px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-mid);
            cursor: pointer;
            text-align: center;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }
        .btn-nominal:hover {
            border-color: var(--gold);
            color: var(--mahogany);
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(200, 148, 26, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(200, 148, 26, 0.35);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .btn-submit:hover {
            box-shadow: 0 6px 20px rgba(200, 148, 26, 0.5);
            transform: translateY(-1px);
        }
        .btn-submit:disabled {
            background: var(--text-muted);
            color: rgba(255, 255, 255, 0.7);
            cursor: not-allowed;
            opacity: 0.7;
            box-shadow: none;
        }

        /* Alert styling */
        .alert {
            padding: 14px 16px;
            border-radius: 6px;
            font-size: 13.5px;
            margin-bottom: 22px;
            display: none;
        }
        .alert-danger { background-color: #fdf2f2; border: 1px solid #f9d5d5; color: var(--danger); }

        /* ═══════════════════════════════════════
           QRIS SIDE PANEL (Sacred Deep Red/Gold)
           ═══════════════════════════════════════ */
        .qris-panel {
            background: linear-gradient(135deg, var(--mahogany-dark) 0%, var(--mahogany-mid) 100%);
            color: #fff;
            padding: 36px;
            border-radius: var(--radius);
            box-shadow: 
                0 10px 30px rgba(44, 24, 16, 0.15),
                0 0 20px rgba(200, 148, 26, 0.2);
            text-align: center;
            border: 1px solid var(--border-warm);
            position: relative;
        }
        .qris-panel::before {
            content: ''; position: absolute;
            top: 10px; left: 10px; right: 10px; bottom: 10px;
            border: 1px solid rgba(200, 148, 26, 0.25);
            border-radius: calc(var(--radius) - 2px);
            pointer-events: none;
        }
        .qris-header {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: var(--gold-light);
            margin-bottom: 14px;
            letter-spacing: -0.01em;
        }
        .qris-desc {
            font-family: 'EB Garamond', serif;
            font-size: 16px;
            color: rgba(255,255,255,0.8);
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .qris-img-container {
            background-color: #fff;
            padding: 14px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 16px;
            max-width: 220px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
            border: 2px solid rgba(200, 148, 26, 0.4);
        }
        .qris-img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 4px;
        }
        .btn-unduh-qris {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 13.5px;
            font-weight: 800;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(200, 148, 26, 0.4);
            transition: all 0.25s ease;
            margin-bottom: 18px;
            cursor: pointer;
            border: none;
        }
        .btn-unduh-qris:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(200, 148, 26, 0.6);
            color: var(--mahogany-dark);
        }
        .btn-unduh-qris:active {
            transform: translateY(0);
        }
        .bank-details {
            background-color: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(200, 148, 26, 0.3);
            border-radius: 8px;
            padding: 18px;
            text-align: left;
            font-size: 14px;
            line-height: 1.6;
        }
        .bank-details-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            color: var(--gold-light);
            margin-bottom: 6px;
            font-size: 12px;
            letter-spacing: 0.05em;
        }

        /* ═══════════════════════════════════════
           RIWAYAT TABLE (Parchment Styled)
           ═══════════════════════════════════════ */
        .table-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            margin-top: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: var(--cream);
            color: var(--text-mid);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1.5px solid var(--border-warm);
        }
        td {
            padding: 12px 14px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border-warm);
            color: var(--text-dark);
        }
        tr:hover td {
            background-color: rgba(200, 148, 26, 0.03);
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .badge-success { background-color: rgba(42, 122, 68, 0.15); color: var(--success); }
        .badge-warning { background-color: rgba(200, 148, 26, 0.15); color: var(--gold-dark); }
        .badge-danger { background-color: rgba(162, 42, 42, 0.15); color: var(--danger); }

        /* ═══════════════════════════════════════
           MOBILE RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 868px) {
            /* split-layout already stacks at 868px */
        }
        @media (max-width: 768px) {
            .container { padding: 20px 14px; }
            .header-logo { flex-wrap: wrap; gap: 10px; }
            .card-header { padding: 18px 18px; }
            .card-body { padding: 18px; }
            .card-title { font-size: 17px; }
            .qris-panel { padding: 22px 18px; }
            .nominal-options { grid-template-columns: repeat(3, 1fr); gap: 8px; }
            
            /* Responsive stack table for history on mobile */
            .table-responsive-stack table,
            .table-responsive-stack thead,
            .table-responsive-stack tbody,
            .table-responsive-stack th,
            .table-responsive-stack td,
            .table-responsive-stack tr {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            .table-responsive-stack thead {
                display: none !important;
            }
            .table-responsive-stack tbody tr {
                background: var(--ivory);
                border: 1px solid var(--border-warm);
                border-radius: 10px;
                padding: 12px 14px;
                margin-bottom: 10px;
            }
            .table-responsive-stack td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 6px 0 !important;
                border-bottom: 1px solid rgba(232, 213, 170, 0.4) !important;
                font-size: 12.5px !important;
                text-align: right !important;
            }
            .table-responsive-stack td:last-child {
                border-bottom: none !important;
            }
            .table-responsive-stack td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--gold-dark);
                font-size: 10.5px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                text-align: left;
            }
        }
        @media (max-width: 480px) {
            .container { padding: 18px 14px; }
            .header-logo { flex-direction: column; align-items: flex-start; gap: 8px; }
            .back-home { font-size: 13px; }
            .card-header { padding: 18px 18px; }
            .card-body { padding: 18px; }
            .card-title { font-size: 16px; }
            .nominal-options { grid-template-columns: repeat(2, 1fr); }
            .qris-panel { padding: 20px 16px; }
            .qris-header { font-size: 17px; }
        }
        @media (max-width: 360px) {
            .container { padding: 14px 10px; }
            .nominal-options { grid-template-columns: repeat(2, 1fr); }
        }
        /* iPhone notch safe area */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            body { padding-bottom: env(safe-area-inset-bottom); }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logo Header -->
        <div class="header-logo">
            <a href="{{ route('home') }}" class="logo-area">
                <img src="{{ asset('images/logo-gemindo.png') }}" alt="Logo GEMINDO" class="header-logo-img">
                <div class="logo-texts">
                    <div class="logo-title">GEMINDO Kawan Kasih</div>
                    <div class="logo-subtitle">Portal Jemaat</div>
                </div>
            </a>
            <a href="{{ route('home') }}" class="back-home">← Kembali ke Halaman Utama</a>
        </div>

        <!-- Split Layout -->
        <div class="split-layout">
            <!-- Payment Form -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Persembahan Syukur</h1>
                        <p class="card-subtitle">"Muliakanlah TUHAN dengan hartamu dan dengan hasil pertama dari segala penghasilanmu." — Amsal 3:9</p>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" id="errorAlert"></div>

                        <form id="paymentForm">
                            @csrf
                            
                            @if(Auth::check())
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            @else
                                <!-- Nama Donatur -->
                                <div class="form-group">
                                    <label class="form-label" for="nama_donatur">Nama Lengkap Donatur <span>*</span></label>
                                    <input type="text" id="nama_donatur" name="nama_donatur" class="form-control" placeholder="Nama lengkap Anda" required>
                                </div>
                                <!-- Email Donatur -->
                                <div class="form-group">
                                    <label class="form-label" for="email_donatur">Alamat Email Donatur <span>*</span></label>
                                    <input type="email" id="email_donatur" name="email_donatur" class="form-control" placeholder="email@example.com" required>
                                </div>
                            @endif

                            <!-- Jenis Persembahan -->
                            <div class="form-group">
                                <label class="form-label" for="jenis_persembahan_id">Jenis Persembahan <span>*</span></label>
                                <select id="jenis_persembahan_id" name="jenis_persembahan_id" class="form-control" required>
                                    <option value="">-- Pilih Jenis Persembahan --</option>
                                    @foreach($jenisPersembahans as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama }} @if($jenis->deskripsi) - ({{ $jenis->deskripsi }}) @endif</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nominal -->
                            <div class="form-group">
                                <label class="form-label" for="nominal">Nominal Persembahan (Rp) <span>*</span></label>
                                <input type="number" id="nominal" name="nominal" class="form-control" min="10000" placeholder="Minimal Rp 10.000" required>
                                <div class="nominal-options">
                                    <button type="button" class="btn-nominal" onclick="setNominal(50000)">50.000</button>
                                    <button type="button" class="btn-nominal" onclick="setNominal(100000)">100.000</button>
                                    <button type="button" class="btn-nominal" onclick="setNominal(250000)">250.000</button>
                                    <button type="button" class="btn-nominal" onclick="setNominal(500000)">500.000</button>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group">
                                <label class="form-label" for="keterangan">Keterangan / Wujud Pokok Doa (Opsional)</label>
                                <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Tuliskan pokok pergumulan doa atau keterangan khusus..."></textarea>
                            </div>

                            <button type="submit" class="btn-submit" id="submitBtn">Lanjutkan Pembayaran</button>
                        </form>
                    </div>
                </div>

                @if(Auth::check() && $riwayat && $riwayat->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title" style="font-size: 16px;">10 Riwayat Persembahan Terakhir Anda</h2>
                        </div>
                        <div class="card-body" style="padding: 20px 24px;">
                            <div class="table-wrapper table-responsive-stack">
                                <table class="table-responsive-stack">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Nominal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $r)
                                            <tr>
                                                <td data-label="Tanggal">{{ $r->created_at->format('d/m/Y') }}</td>
                                                <td data-label="Jenis" class="cell-title">{{ $r->jenisPersembahan->nama ?? '-' }}</td>
                                                <td data-label="Nominal" style="font-weight: 700; color: var(--success);">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                                                <td data-label="Status">
                                                    @if($r->status === 'success')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif($r->status === 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger">Gagal</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- QRIS Side Panel -->
            <div>
                <div class="qris-panel">
                    <h2 class="qris-header">Metode Alternatif</h2>
                    <p class="qris-desc">
                        Selain melalui formulir persembahan digital online di atas, Anda juga dapat memberikan persembahan secara langsung via kode QRIS Statis maupun transfer ke rekening bank resmi gereja berikut.
                    </p>

                    @php
                        $qrisBarcodeSrc = $qrisStatis ? asset('storage/' . $qrisStatis) : asset('images/qris-persembahan.png');
                    @endphp
                    <div class="qris-img-container">
                        <!-- Barcode QRIS Persembahan -->
                        <img id="qrisBarcodeImg" src="{{ $qrisBarcodeSrc }}" alt="Barcode QRIS Persembahan GEMINDO" class="qris-img">
                    </div>
                    <div style="margin-bottom: 8px;">
                        <a href="{{ route('persembahan.download-qris') }}" 
                           download="QRIS-Persembahan-GEMINDO.png" 
                           id="btnUnduhQris"
                           class="btn-unduh-qris" 
                           onclick="handleQrisDownload(event, '{{ $qrisBarcodeSrc }}', '{{ route('persembahan.download-qris') }}')">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span id="btnUnduhQrisText">Unduh Barcode QRIS</span>
                        </a>
                    </div>
                    <div style="font-size:13px; color:rgba(255,255,255,0.75); margin-bottom: 24px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 500; line-height: 1.5;">
                        Pindai atau unduh barcode QRIS di atas untuk persembahan via mobile banking (BCA, Mandiri, BRI, BNI, dll) atau dompet digital.
                    </div>

                    @if($rekening)
                        <div class="bank-details">
                            <div class="bank-details-title">🏦 REKENING RESMI GEREJA</div>
                            <div style="white-space: pre-line; color: rgba(255,255,255,0.85); font-family: 'Inter', sans-serif;">{{ $rekening }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap JS -->
    @if($isProduction)
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @endif

    <script>
        function setNominal(amount) {
            document.getElementById('nominal').value = amount;
        }

        const form = document.getElementById('paymentForm');
        const submitBtn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('errorAlert');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.innerText = 'Memproses...';
            errorAlert.style.display = 'none';

            const formData = new FormData(form);

            fetch("{{ route('persembahan.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = "/persembahan/success/" + data.order_id;
                        },
                        onPending: function(result) {
                            alert('Pembayaran ditunda, mohon selesaikan pembayaran Anda.');
                            window.location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal, mohon coba kembali.');
                            window.location.reload();
                        },
                        onClose: function() {
                            submitBtn.disabled = false;
                            submitBtn.innerText = 'Lanjutkan Pembayaran';
                        }
                    });
                } else {
                    throw { message: data.message || 'Gagal memproses pembayaran.' };
                }
            })
            .catch(err => {
                console.error(err);
                errorAlert.innerText = err.message || 'Terjadi kesalahan sistem, silakan coba lagi.';
                errorAlert.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.innerText = 'Lanjutkan Pembayaran';
            });
        });

        function handleQrisDownload(e, imgSrc, downloadUrl) {
            if (window.fetch && window.Blob) {
                e.preventDefault();
                const btn = document.getElementById('btnUnduhQris');
                const textSpan = document.getElementById('btnUnduhQrisText');
                const origText = textSpan ? textSpan.innerText : 'Unduh Barcode QRIS';
                if (textSpan) textSpan.innerText = 'Mengunduh...';
                if (btn) {
                    btn.style.opacity = '0.75';
                    btn.style.pointerEvents = 'none';
                }

                fetch(downloadUrl || imgSrc)
                    .then(function(res) {
                        if (!res.ok) throw new Error('Download failed');
                        return res.blob();
                    })
                    .then(function(blob) {
                        const blobUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = blobUrl;
                        a.download = 'QRIS-Persembahan-GEMINDO.png';
                        document.body.appendChild(a);
                        a.click();
                        setTimeout(function() {
                            window.URL.revokeObjectURL(blobUrl);
                            document.body.removeChild(a);
                            if (textSpan) textSpan.innerText = '✅ Berhasil Diunduh!';
                            setTimeout(function() {
                                if (textSpan) textSpan.innerText = origText;
                                if (btn) {
                                    btn.style.opacity = '';
                                    btn.style.pointerEvents = '';
                                }
                            }, 2200);
                        }, 400);
                    })
                    .catch(function(err) {
                        console.warn('[QRIS Download Fallback]', err);
                        window.location.href = downloadUrl;
                        setTimeout(function() {
                            if (textSpan) textSpan.innerText = origText;
                            if (btn) {
                                btn.style.opacity = '';
                                btn.style.pointerEvents = '';
                            }
                        }, 1500);
                    });
            }
        }
    </script>

</body>
</html>
