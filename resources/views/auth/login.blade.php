@extends('layouts.guest')

@section('title', 'Masuk')

@section('styles')
<style>
    /* Credentials Panel */
    .cred-panel {
        margin-top: 16px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,.35), 0 0 0 1px rgba(200,148,26,.2);
    }
    .cred-toggle {
        width: 100%; padding: 13px 18px;
        background: linear-gradient(135deg, rgba(44,24,16,.97), rgba(61,35,23,.97));
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        color: var(--accent-light); letter-spacing: -0.01em;
        transition: background .2s;
    }
    .cred-toggle:hover { background: linear-gradient(135deg, rgba(61,35,23,1), rgba(80,45,28,1)); }
    .cred-toggle .arrow { transition: transform .3s ease; font-size: 11px; opacity: .7; }
    .cred-toggle.open .arrow { transform: rotate(180deg); }

    .cred-body {
        background: rgba(18,10,6,.95);
        border-top: 1px solid rgba(200,148,26,.15);
        max-height: 0; overflow: hidden;
        transition: max-height .35s ease;
    }
    .cred-body.open {
        max-height: 380px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }
    .cred-body::-webkit-scrollbar { width: 5px; }
    .cred-body::-webkit-scrollbar-track { background: rgba(0,0,0,.2); }
    .cred-body::-webkit-scrollbar-thumb { background: rgba(200,148,26,.35); border-radius: 4px; }

    .cred-inner {
        padding: 14px 12px;
        overflow-x: hidden;
    }

    .cred-note {
        font-size: 12px; color: rgba(200,148,26,.75);
        text-align: center; margin-bottom: 12px;
        font-style: italic; font-family: 'EB Garamond', serif;
    }

    .cred-head-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 8px 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        color: rgba(200,148,26,.8);
        text-transform: uppercase;
        letter-spacing: .06em;
        border-bottom: 1px solid rgba(200,148,26,.18);
        margin-bottom: 6px;
    }

    .cred-list {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .cred-item {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 8px;
        border-bottom: 1px solid rgba(255,255,255,.04);
        gap: 8px;
        border-radius: 6px;
        transition: background .15s;
    }
    .cred-item:last-child { border-bottom: none; }
    .cred-item:hover { background: rgba(200,148,26,.08); }

    .cred-item-info {
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
        flex: 1;
        overflow: hidden;
    }

    .role-badge {
        display: inline-block; padding: 2px 8px; border-radius: 20px;
        font-size: 10.5px; font-weight: 700; letter-spacing: .02em;
        background: rgba(200,148,26,.15); color: var(--accent-light);
        border: 1px solid rgba(200,148,26,.25); white-space: nowrap;
        font-family: 'Plus Jakarta Sans', sans-serif;
        flex-shrink: 0;
    }
    .role-badge.admin-b { background: rgba(139,26,26,.25); color: #f9a8a8; border-color: rgba(139,26,26,.35); }
    .role-badge.majelis-b { background: rgba(45,106,79,.2); color: #86efac; border-color: rgba(45,106,79,.3); }
    .role-badge.jemaat-b { background: rgba(59,130,246,.15); color: #93c5fd; border-color: rgba(59,130,246,.25); }

    .email-cell {
        font-size: 10.5px;
        color: rgba(255,255,255,.7);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        word-break: break-all;
        overflow-wrap: anywhere;
        max-width: 100%;
        line-height: 1.4;
    }

    .fill-btn {
        padding: 4px 11px; border-radius: 6px; font-size: 11px; font-weight: 700;
        background: rgba(200,148,26,.2); color: var(--accent-light);
        border: 1px solid rgba(200,148,26,.3); cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif; transition: all .15s;
        white-space: nowrap; flex-shrink: 0;
    }
    .fill-btn:hover {
        background: rgba(200,148,26,.45);
        color: #fff;
        border-color: var(--accent-light);
    }

    .pw-hint {
        text-align: center; margin-top: 12px; padding-top: 10px;
        border-top: 1px solid rgba(200,148,26,.1);
        font-size: 11.5px; color: rgba(255,255,255,.45);
        font-family: 'EB Garamond', serif; font-style: italic;
    }
    .pw-hint code {
        font-style: normal; color: rgba(200,148,26,.8);
        background: rgba(200,148,26,.1); padding: 1px 7px; border-radius: 4px; font-size: 12px;
    }
</style>
@endsection

@section('content')
<h1 class="card-title">Selamat Datang</h1>
<p class="card-sub">Masuk ke portal jemaat GEMINDO Kawan Kasih</p>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
               value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
               placeholder="••••••••" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label class="checkbox-group">
            <input type="checkbox" name="remember"> Ingat saya
        </label>
    </div>

    <button type="submit" class="btn-submit">Masuk ke Portal</button>
</form>

<div class="divider"><span>atau</span></div>

<p style="text-align:center; font-size:13px; color:#64748b;">
    Belum terdaftar sebagai jemaat?<br>
    <a href="{{ route('daftar-jemaat') }}" class="text-link">Daftar sebagai jemaat baru →</a>
</p>

{{-- Credentials Reference Panel (Demo) --}}
<div class="cred-panel">
    <button class="cred-toggle" id="credToggle" type="button">
        <span>🔑 Akun Demo — Referensi Login</span>
        <span class="arrow">▼</span>
    </button>
    <div class="cred-body" id="credBody">
        <div class="cred-inner">
            <p class="cred-note">Klik "Isi ↗" untuk mengisi formulir login secara otomatis</p>
            <div class="cred-head-row">
                <span>Role & Email</span>
                <span>Aksi</span>
            </div>
            <div class="cred-list">
                @php
                    $demoAccounts = [
                        ['label' => 'Super Admin',    'class' => 'admin-b',   'email' => 'admin@gemindokawankasih.or.id',           'pw' => 'Admin@12345'],
                        ['label' => 'Majelis',        'class' => 'majelis-b', 'email' => 'majelis@gemindokawankasih.or.id',         'pw' => 'Majelis@12345'],
                        ['label' => 'Sekretaris',     'class' => '',          'email' => 'sekretaris@gemindokawankasih.or.id',      'pw' => 'Secret@12345'],
                        ['label' => 'Bendahara',      'class' => '',          'email' => 'bendahara@gemindokawankasih.or.id',       'pw' => 'Secret@12345'],
                        ['label' => 'Pengurus KPB',   'class' => '',          'email' => 'pengurus.kpb@gemindokawankasih.or.id',   'pw' => 'Secret@12345'],
                        ['label' => 'Pengurus KPW',   'class' => '',          'email' => 'pengurus.kpw@gemindokawankasih.or.id',   'pw' => 'Secret@12345'],
                        ['label' => 'Pengurus KPP',   'class' => '',          'email' => 'pengurus.kpp@gemindokawankasih.or.id',   'pw' => 'Secret@12345'],
                        ['label' => 'Pengurus KPR',   'class' => '',          'email' => 'pengurus.kpr@gemindokawankasih.or.id',   'pw' => 'Secret@12345'],
                        ['label' => 'Pengurus KPA',   'class' => '',          'email' => 'pengurus.kpa@gemindokawankasih.or.id',   'pw' => 'Secret@12345'],
                        ['label' => 'Jemaat',         'class' => 'jemaat-b',  'email' => 'anita.malonda@gemindokawankasih.or.id',  'pw' => 'Secret@12345'],
                    ];
                @endphp
                @foreach($demoAccounts as $acc)
                <div class="cred-item">
                    <div class="cred-item-info">
                        <span class="role-badge {{ $acc['class'] }}">{{ $acc['label'] }}</span>
                        <span class="email-cell">{{ $acc['email'] }}</span>
                    </div>
                    <button class="fill-btn" data-email="{{ $acc['email'] }}" data-pw="{{ $acc['pw'] }}" type="button">Isi ↗</button>
                </div>
                @endforeach
            </div>
            <p class="pw-hint">
                Super Admin: <code>Admin@12345</code> &nbsp;|&nbsp; Majelis: <code>Majelis@12345</code><br>
                Semua role lainnya: <code>Secret@12345</code>
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-fill credentials
    document.querySelectorAll('.fill-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('email').value    = this.dataset.email;
            document.getElementById('password').value = this.dataset.pw || 'Secret@12345';
            document.getElementById('email').focus();
            // Close panel after fill
            document.getElementById('credBody').classList.remove('open');
            document.getElementById('credToggle').classList.remove('open');
        });
    });

    // Toggle credentials panel
    document.getElementById('credToggle').addEventListener('click', function() {
        const body = document.getElementById('credBody');
        const isOpen = body.classList.contains('open');
        body.classList.toggle('open', !isOpen);
        this.classList.toggle('open', !isOpen);
    });
</script>
@endsection
