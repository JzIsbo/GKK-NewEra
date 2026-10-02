<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Jemaat Baru – GEMINDO Kawan Kasih</title>
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
            --danger:        #a22a2a;
            --success:       #2a7a44;
            --radius:        10px;
            --transition:    all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background: var(--parchment);
            /* Soft candlelight radial glow */
            background-image: 
                radial-gradient(ellipse 60% 40% at 50% 0%, rgba(200, 148, 26, 0.08) 0%, transparent 70%),
                radial-gradient(ellipse 50% 50% at 50% 100%, rgba(107, 26, 46, 0.04) 0%, transparent 70%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.7;
        }

        .container {
            width: 100%;
            max-width: 840px;
            margin: 0 auto;
            padding: 50px 24px;
        }

        /* ═══════════════════════════════════════
           HEADER LOGO (Spiritual Theme)
           ═══════════════════════════════════════ */
        .header-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-bottom: 36px;
            text-align: center;
        }
        
        .logo-cross-wrap {
            position: relative; 
            width: 36px; 
            height: 48px; 
            flex-shrink: 0;
            margin-bottom: 12px;
        }
        .logo-cross-wrap::before {
            content: ''; position: absolute;
            left: 50%; top: 0; transform: translateX(-50%);
            width: 7px; height: 100%;
            background: linear-gradient(180deg, var(--gold-light), var(--gold-dark));
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(200,148,26,.5);
        }
        .logo-cross-wrap::after {
            content: ''; position: absolute;
            left: 0; top: 35%;
            width: 100%; height: 7px;
            background: linear-gradient(90deg, var(--gold-light), var(--gold-dark));
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(200,148,26,.5);
        }

        .logo-title {
            font-family: 'Cinzel', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--mahogany);
            line-height: 1.2;
            letter-spacing: 0.04em;
        }
        .logo-subtitle {
            font-family: 'EB Garamond', serif;
            font-size: 13px;
            color: var(--text-muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════
           FORM CARD (Sacred Parchment Card)
           ═══════════════════════════════════════ */
        .form-card {
            background-color: var(--ivory);
            border-radius: var(--radius);
            border: 1px solid var(--border-warm);
            box-shadow: 
                0 10px 30px rgba(44, 24, 16, 0.05),
                0 1px 3px rgba(200, 148, 26, 0.1),
                inset 0 0 40px rgba(250, 240, 215, 0.5);
            padding: 44px;
            margin-bottom: 28px;
            position: relative;
        }
        
        /* Ornamental corner accents */
        .form-card::before {
            content: ''; position: absolute;
            top: 12px; left: 12px; right: 12px; bottom: 12px;
            border: 1px solid rgba(200, 148, 26, 0.15);
            border-radius: calc(var(--radius) - 4px);
            pointer-events: none;
        }

        .form-title {
            font-family: 'Cinzel Decorative', serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--mahogany);
            margin-bottom: 8px;
            text-align: center;
        }
        .form-subtitle {
            font-family: 'EB Garamond', serif;
            font-size: 16px;
            color: var(--text-mid);
            text-align: center;
            margin-bottom: 24px;
            font-style: italic;
        }

        /* Ornamental Gold Divider */
        .form-divider {
            display: flex; align-items: center; gap: 12px;
            justify-content: center; margin-bottom: 30px;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1; max-width: 100px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-warm));
        }
        .form-divider::after { background: linear-gradient(270deg, transparent, var(--border-warm)); }
        .form-divider span {
            font-size: 12px; color: var(--gold-dark);
            font-family: 'Cinzel', serif; letter-spacing: 0.15em;
        }

        /* ═══════════════════════════════════════
           ALERTS & BULLETINS
           ═══════════════════════════════════════ */
        .alert {
            padding: 16px 20px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
            position: relative;
            z-index: 2;
        }
        .alert-danger {
            background-color: #fdf2f2;
            border: 1px solid #f9d5d5;
            color: var(--danger);
        }
        .alert-danger ul {
            padding-left: 20px;
            margin-top: 6px;
        }

        .info-box {
            background-color: var(--cream);
            border-left: 3px solid var(--gold);
            padding: 18px;
            border-radius: 6px;
            margin-bottom: 32px;
            font-size: 14px;
            color: var(--text-dark);
            font-family: 'EB Garamond', serif;
            font-size: 16px;
            line-height: 1.6;
            position: relative;
            z-index: 2;
        }
        .info-box-title {
            font-family: 'Cinzel', serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--mahogany);
            margin-bottom: 6px;
            letter-spacing: 0.05em;
        }

        /* ═══════════════════════════════════════
           FORM LAYOUT & CONTROLS
           ═══════════════════════════════════════ */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            position: relative;
            z-index: 2;
        }
        @media (max-width: 640px) {
            .grid-2 { grid-template-columns: 1fr; }
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-group.full-width {
            grid-column: span 2;
        }
        @media (max-width: 640px) {
            .form-group.full-width { grid-column: span 1; }
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 6px;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
        .form-label span {
            color: var(--danger);
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
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
        .form-control.is-invalid {
            border-color: var(--danger);
        }
        
        textarea.form-control {
            resize: vertical;
        }

        /* Select styling override */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238a6a42' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
            padding-right: 40px;
        }

        /* ═══════════════════════════════════════
           BUTTONS & FOOTER
           ═══════════════════════════════════════ */
        .form-footer {
            margin-top: 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            z-index: 2;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 13px 28px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            color: var(--mahogany-dark);
            box-shadow: 0 4px 14px rgba(200, 148, 26, 0.3);
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

        .back-link {
            display: block;
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-family: 'EB Garamond', serif;
            font-style: italic;
            font-size: 16px;
            transition: var(--transition);
        }
        .back-link:hover {
            color: var(--gold-dark);
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════
           MOBILE RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 768px) {
            .container { padding: 30px 18px; }
            .form-card {
                padding: 28px 22px 32px;
                border-radius: 14px;
            }
            .form-title { font-size: 22px; }
            .form-subtitle { font-size: 15px; }
        }
        @media (max-width: 480px) {
            .container { padding: 20px 14px; }
            .form-card { padding: 22px 16px 26px; }
            .form-title { font-size: 19px; }
            .form-footer {
                flex-direction: column-reverse;
                gap: 10px;
            }
            .form-footer .btn { width: 100%; text-align: center; }
            .grid-2 { gap: 14px; }
        }
        @media (max-width: 360px) {
            .container { padding: 16px 12px; }
        }
        /* iPhone safe area */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            body { padding-bottom: env(safe-area-inset-bottom); }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="header-logo">
            <div class="logo-cross-wrap"></div>
            <div class="logo-text-wrapper">
                <div class="logo-title">GEMINDO Kawan Kasih</div>
                <div class="logo-subtitle">Portal Jemaat</div>
            </div>
        </a>

        <!-- Form Card -->
        <div class="form-card">
            <h1 class="form-title">Pendaftaran Jemaat Baru</h1>
            <p class="form-subtitle">"Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, di situ Aku ada di tengah-tengah mereka."</p>

            <div class="form-divider">
                <span>SOLI DEO GLORIA</span>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <div style="font-weight: 700;">Mohon koreksi kesalahan berikut:</div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="info-box">
                <div class="info-box-title">⛪ Alur Pendaftaran Jemaat</div>
                <div>Setelah mengisi formulir ini, berkas Anda akan ditinjau oleh Majelis Jemaat. Apabila disetujui, Anda akan mendapatkan akun akses portal resmi beserta Nomor Induk Jemaat (NIJ) yang dikirimkan langsung ke alamat email terdaftar.</div>
            </div>

            <form method="POST" action="{{ route('daftar-jemaat.store') }}">
                @csrf
                
                <div class="grid-2">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label class="form-label" for="nama_lengkap">Nama Lengkap <span>*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}" 
                               value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap sesuai KTP" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Alamat Email <span>*</span></label>
                        <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                               value="{{ old('email') }}" placeholder="email@example.com" required>
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group">
                        <label class="form-label" for="no_telepon">No. Telepon / WhatsApp <span>*</span></label>
                        <input type="text" id="no_telepon" name="no_telepon" class="form-control {{ $errors->has('no_telepon') ? 'is-invalid' : '' }}" 
                               value="{{ old('no_telepon') }}" placeholder="Contoh: 08123456789" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group">
                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form-group">
                        <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" 
                               value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-group">
                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" 
                               value="{{ old('tanggal_lahir') }}">
                    </div>

                    <!-- Pekerjaan -->
                    <div class="form-group">
                        <label class="form-label" for="pekerjaan">Pekerjaan</label>
                        <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" 
                               value="{{ old('pekerjaan') }}" placeholder="Pekerjaan saat ini">
                    </div>

                    <!-- Asal Gereja -->
                    <div class="form-group">
                        <label class="form-label" for="asal_gereja">Asal Gereja (Sebelumnya)</label>
                        <input type="text" id="asal_gereja" name="asal_gereja" class="form-control" 
                               value="{{ old('asal_gereja') }}" placeholder="Nama gereja terdahulu">
                    </div>

                    <!-- Alamat -->
                    <div class="form-group full-width">
                        <label class="form-label" for="alamat">Alamat Tinggal Sekarang <span>*</span></label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap tinggal saat ini" required>{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Alasan Bergabung -->
                    <div class="form-group full-width">
                        <label class="form-label" for="alasan_bergabung">Alasan Bergabung / Keterangan Lain</label>
                        <textarea id="alasan_bergabung" name="alasan_bergabung" class="form-control" rows="3" placeholder="Alasan mendaftar atau informasi tambahan">{{ old('alasan_bergabung') }}</textarea>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('home') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                </div>
            </form>
        </div>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke Halaman Utama</a>
    </div>

</body>
</html>
