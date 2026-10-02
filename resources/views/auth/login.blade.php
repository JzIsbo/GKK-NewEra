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
        font-family: 'Cinzel', serif; font-size: 13px; font-weight: 600;
        color: var(--accent-light); letter-spacing: .05em;
        transition: background .2s;
    }
    .cred-toggle:hover { background: linear-gradient(135deg, rgba(61,35,23,1), rgba(80,45,28,1)); }
    .cred-toggle .arrow { transition: transform .3s ease; font-size: 11px; opacity: .7; }
    .cred-toggle.open .arrow { transform: rotate(180deg); }

    .cred-body {
        background: rgba(18,10,6,.95);
        border-top: 1px solid rgba(200,148,26,.15);
        max-height: 0; overflow: hidden;
        transition: max-height .4s ease;
    }
    .cred-body.open { max-height: 700px; }
    .cred-inner { padding: 16px 18px; }

    .cred-note {
        font-size: 11.5px; color: rgba(200,148,26,.6);
        text-align: center; margin-bottom: 14px;
        font-style: italic; font-family: 'EB Garamond', serif;
    }
    .cred-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .cred-table th {
        font-family: 'Cinzel', serif; font-size: 10px; font-weight: 600;
        color: rgba(200,148,26,.7); text-transform: uppercase; letter-spacing: .08em;
        padding: 6px 8px; text-align: left;
        border-bottom: 1px solid rgba(200,148,26,.12);
    }
    .cred-table td {
        padding: 7px 8px; vertical-align: middle;
        border-bottom: 1px solid rgba(255,255,255,.04);
        color: rgba(255,255,255,.75); font-family: 'Inter', sans-serif;
    }
    .cred-table tr:last-child td { border-bottom: none; }
    .cred-table tr:hover td { background: rgba(200,148,26,.05); }

    .role-badge {
        display: inline-block; padding: 2px 8px; border-radius: 20px;
        font-size: 10px; font-weight: 600; letter-spacing: .02em;
        background: rgba(200,148,26,.15); color: var(--accent-light);
        border: 1px solid rgba(200,148,26,.25); white-space: nowrap;
    }
    .role-badge.admin-b { background: rgba(139,26,26,.25); color: #f9a8a8; border-color: rgba(139,26,26,.35); }
    .role-badge.majelis-b { background: rgba(45,106,79,.2); color: #86efac; border-color: rgba(45,106,79,.3); }
    .role-badge.jemaat-b { background: rgba(59,130,246,.15); color: #93c5fd; border-color: rgba(59,130,246,.25); }

    .fill-btn {
        padding: 3px 9px; border-radius: 6px; font-size: 10.5px; font-weight: 600;
        background: rgba(200,148,26,.2); color: var(--accent-light);
        border: 1px solid rgba(200,148,26,.3); cursor: pointer;
        font-family: 'Inter', sans-serif; transition: background .15s; white-space: nowrap;
    }
    .fill-btn:hover { background: rgba(200,148,26,.38); }

    .pw-hint {
        text-align: center; margin-top: 12px; padding-top: 10px;
        border-top: 1px solid rgba(200,148,26,.1);
        font-size: 11.5px; color: rgba(255,255,255,.4);
        font-family: 'EB Garamond', serif; font-style: italic;
    }
    .pw-hint code {
        font-style: normal; color: rgba(200,148,26,.75);
        background: rgba(200,148,26,.1); padding: 1px 7px; border-radius: 4px; font-size: 12px;
    }
    .email-cell { font-size: 11px; color: rgba(255,255,255,.55); }
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
            <table class="cred-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
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
                    <tr>
                        <td><span class="role-badge {{ $acc['class'] }}">{{ $acc['label'] }}</span></td>
                        <td class="email-cell">{{ $acc['email'] }}</td>
                        <td><button class="fill-btn" data-email="{{ $acc['email'] }}" data-pw="{{ $acc['pw'] }}" type="button">Isi ↗</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
