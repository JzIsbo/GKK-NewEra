@extends('layouts.app')

@section('title', 'Panitia HABERJA (Hari Besar Gereja)')
@section('header-title', 'Panitia HABERJA')

@section('content')
<div class="haberja-container">

    <!-- PAGE HEADER -->
    <div class="page-header haberja-page-header">
        <div>
            <h1 class="page-header-title">Panitia Hari-Hari Besar Gereja (HABERJA)</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pelayanan Jemaat</span> &gt; <span>Panitia HABERJA</span>
            </div>
        </div>
        <div class="haberja-header-actions">
            <a href="{{ route('haberja.print', ['event' => $selectedKode]) }}" target="_blank" class="btn btn-outline btn-sm">
                🖨️ <span class="hide-xs">Cetak / Print</span> RAB
            </a>
            @if($canManage)
                @if($activeTab === 'struktur')
                    <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modalTambahPanitia')">
                        ➕ <span class="hide-xs">Tambah</span> Personil
                    </button>
                @elseif($activeTab === 'dana')
                    <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modalTambahDana')">
                        ➕ <span class="hide-xs">Tambah</span> Program Dana
                    </button>
                @elseif($activeTab === 'budget')
                    <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modalTambahBudget')">
                        ➕ <span class="hide-xs">Tambah</span> Item RAB
                    </button>
                @endif
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-3">✕ {{ session('error') }}</div>
    @endif

    <!-- HERO CARD & EVENT CHIP SELECTOR -->
    <div class="card haberja-hero-card mb-4">
        <div class="haberja-watermark">✝</div>
        <div class="card-body haberja-hero-body">
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                <span class="badge badge-gold" style="font-size: 10px; letter-spacing: 0.5px; text-transform: uppercase;">HABERJA 2026</span>
                @if($currentEvent)
                    <span class="badge badge-info" style="font-size: 10.5px;">{{ $currentEvent->nama }}</span>
                @else
                    <span class="badge badge-secondary" style="font-size: 10.5px;">Konsolidasi Seluruh Acara</span>
                @endif
                <span class="badge" style="background: rgba(255,255,255,0.15); color: #fff; font-size: 10.5px;">
                    👥 {{ $panitias->count() }} Personil
                </span>
            </div>

            <h2 class="haberja-hero-title">
                @if($currentEvent)
                    {{ $currentEvent->nama }}
                @else
                    Badan Panitia Hari-Hari Besar Gereja GEMINDO Kawan Kasih
                @endif
            </h2>

            <p class="haberja-hero-desc">
                @if($currentEvent)
                    <em>"{{ $currentEvent->tema }}"</em> &mdash; <strong>{{ $currentEvent->ayat_tema }}</strong>
                    <br><span style="font-size: 12px; opacity: 0.92;">{{ $currentEvent->deskripsi }}</span>
                @else
                    Mengorganisir perencanaan, kepanitiaan, pencarian dana, dan pelaksanaan 3 Hari Besar Utama: 
                    <strong>Paskah</strong>, <strong>HUT Ke-28 Gereja</strong>, serta <strong>Natal &amp; Tahun Baru</strong> secara transparan, partisipatif, dan akuntabel.
                @endif
            </p>

            <!-- EVENT SELECTOR CHIPS (HORIZONTAL SCROLLABLE ON MOBILE) -->
            <div class="haberja-chips-container">
                <span class="haberja-chips-label">Pilih Acara:</span>
                <div class="haberja-chips-scroll">
                    <a href="{{ route('haberja.index', ['event' => 'semua', 'tab' => $activeTab]) }}" 
                       class="haberja-chip {{ $selectedKode === 'semua' ? 'active' : '' }}">
                        ✨ Semua Acara
                    </a>
                    @foreach($events as $ev)
                        <a href="{{ route('haberja.index', ['event' => $ev->kode, 'tab' => $activeTab]) }}" 
                           class="haberja-chip {{ $selectedKode === $ev->kode ? 'active' : '' }}">
                            @if($ev->kode === 'paskah') 🕊️ @elseif($ev->kode === 'hut') 🎂 @else 🎄 @endif
                            {{ $ev->nama }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- RESPONSIVE HORIZONTAL NAVIGATION TABS -->
    <div class="haberja-tabs-nav mb-4">
        <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'overview']) }}" 
           class="haberja-tab-link {{ $activeTab === 'overview' ? 'active' : '' }}">
            <span class="tab-icon">📊</span>
            <span class="tab-text">Ringkasan &amp; Agenda</span>
        </a>
        <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'struktur']) }}" 
           class="haberja-tab-link {{ $activeTab === 'struktur' ? 'active' : '' }}">
            <span class="tab-icon">👥</span>
            <span class="tab-text">Struktur Panitia</span>
            <span class="tab-badge">{{ $panitias->count() }}</span>
        </a>
        <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'dana']) }}" 
           class="haberja-tab-link {{ $activeTab === 'dana' ? 'active' : '' }}">
            <span class="tab-icon">💰</span>
            <span class="tab-text">Planning Dana</span>
            <span class="tab-badge tab-badge-gold">{{ $persenDana }}%</span>
        </a>
        <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'budget']) }}" 
           class="haberja-tab-link {{ $activeTab === 'budget' ? 'active' : '' }}">
            <span class="tab-icon">📋</span>
            <span class="tab-text">Budgeting &amp; RAB</span>
            <span class="tab-badge tab-badge-info">{{ $pengeluarans->count() }} Pos</span>
        </a>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: OVERVIEW & AGENDA                   -->
    <!-- ========================================== -->
    @if($activeTab === 'overview')
        <!-- 4 RESPONSIVE KPI CARDS (2x2 on mobile, 4x1 on desktop) -->
        <div class="haberja-kpi-grid mb-4">
            <div class="card haberja-kpi-card kpi-accent">
                <div class="kpi-header">
                    <span class="kpi-label">Target Anggaran (RAB)</span>
                    <span class="kpi-icon">📋</span>
                </div>
                <div class="kpi-value">Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}</div>
                <div class="kpi-desc">Total kebutuhan dana operasional</div>
            </div>

            <div class="card haberja-kpi-card kpi-success">
                <div class="kpi-header">
                    <span class="kpi-label">Dana Usaha &amp; Donasi</span>
                    <span class="kpi-icon">💰</span>
                </div>
                <div class="kpi-value kpi-val-success">Rp {{ number_format($totalRealisasiDana, 0, ',', '.') }}</div>
                <div class="kpi-progress-wrap">
                    <div class="kpi-progress-bar">
                        <div class="kpi-progress-fill" style="width: {{ $persenDana }}%;"></div>
                    </div>
                    <span class="kpi-progress-pct">{{ $persenDana }}%</span>
                </div>
            </div>

            <div class="card haberja-kpi-card kpi-burgundy">
                <div class="kpi-header">
                    <span class="kpi-label">Realisasi Belanja</span>
                    <span class="kpi-icon">📉</span>
                </div>
                <div class="kpi-value kpi-val-burgundy">Rp {{ number_format($totalRealisasiPengeluaran, 0, ',', '.') }}</div>
                <div class="kpi-desc">Belanja operasional yang telah dikeluarkan</div>
            </div>

            <div class="card haberja-kpi-card kpi-warning">
                <div class="kpi-header">
                    <span class="kpi-label">Sisa Target Usaha Dana</span>
                    <span class="kpi-icon">🎯</span>
                </div>
                <div class="kpi-value kpi-val-warning">Rp {{ number_format($sisaTargetDana, 0, ',', '.') }}</div>
                <div class="kpi-desc">Kekurangan target yang sedang dipacu</div>
            </div>
        </div>

        <!-- 3 ACARA HARI BESAR SHOWCASE -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Agenda 3 Acara Hari Besar Gereja GEMINDO (HABERJA 2026)</div>
                <span class="badge badge-gold hide-xs">Kalender Gerejawi</span>
            </div>
            <div class="card-body" style="padding: 16px;">
                <div class="haberja-events-grid">
                    @foreach($events as $ev)
                        <div class="haberja-event-card">
                            <div class="event-card-top">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="event-emoji">
                                        @if($ev->kode === 'paskah') 🕊️ @elseif($ev->kode === 'hut') 🎂 @else 🎄 @endif
                                    </div>
                                    <span class="badge {{ $ev->kode === 'paskah' ? 'badge-success' : ($ev->kode === 'hut' ? 'badge-gold' : 'badge-danger') }}">
                                        {{ strtoupper($ev->kode) }} 2026
                                    </span>
                                </div>
                                <h3 class="event-title">{{ $ev->nama }}</h3>
                                <div class="event-verse">
                                    📖 {{ $ev->ayat_tema }}: "{{ $ev->tema }}"
                                </div>
                                <p class="event-desc">
                                    {{ $ev->deskripsi }}
                                </p>
                            </div>
                            <div class="event-card-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                                    <span class="text-muted">Target RAB:</span>
                                    <strong style="color: var(--primary);">Rp {{ number_format($ev->target_anggaran, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 12px;">
                                    <span class="text-muted">Jadwal:</span>
                                    <strong>{{ $ev->tanggal_mulai ? $ev->tanggal_mulai->format('d M Y') : '-' }}</strong>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('haberja.index', ['event' => $ev->kode, 'tab' => 'budget']) }}" class="btn btn-outline btn-sm" style="flex: 1; font-size: 12px; justify-content: center;">
                                        Lihat RAB
                                    </a>
                                    <a href="{{ route('haberja.index', ['event' => $ev->kode, 'tab' => 'struktur']) }}" class="btn btn-primary btn-sm" style="flex: 1; font-size: 12px; justify-content: center;">
                                        Panitia
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- QUICK SNAPSHOTS: DANA & STRUKTUR -->
        <div class="haberja-overview-grid">
            <!-- Snapshot Usaha Dana -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Progress Program Usaha Dana</div>
                    <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'dana']) }}" class="small link-accent">
                        Lihat Semua &rarr;
                    </a>
                </div>
                <div class="card-body" style="padding: 16px;">
                    <div class="snapshot-list">
                        @forelse($danaPlans->take(4) as $dp)
                            <div class="snapshot-card">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                    <div class="fw-bold" style="font-size: 13.5px; color: var(--primary); line-height: 1.35;">{{ $dp->nama_program }}</div>
                                    <span class="badge {{ $dp->status === 'tercapai' || $dp->status === 'selesai' ? 'badge-success' : 'badge-gold' }}" style="font-size: 10px; flex-shrink: 0;">
                                        {{ ucfirst($dp->status) }}
                                    </span>
                                </div>
                                <div class="text-muted small mb-2" style="font-size: 11.5px;">PIC: <strong>{{ $dp->penanggung_jawab }}</strong></div>
                                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2" style="font-size: 12px;">
                                    <span>Terkumpul: <strong style="color: var(--success); font-size: 12.5px;">Rp {{ number_format($dp->realisasi_dana, 0, ',', '.') }}</strong></span>
                                    <span class="text-muted">Target: <strong>Rp {{ number_format($dp->target_dana, 0, ',', '.') }}</strong></span>
                                </div>
                                <div class="mini-progress">
                                    <div class="mini-progress-fill" style="width: {{ $dp->persentase }}%;"></div>
                                </div>
                                <div class="text-end mt-1" style="font-size: 10.5px; font-weight: 700; color: {{ $dp->persentase >= 100 ? 'var(--success)' : 'var(--accent-dark)' }};">
                                    {{ $dp->persentase }}% Tercapai
                                </div>
                            </div>
                        @empty
                            <div class="text-muted text-center py-4">Belum ada program dana.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Snapshot BPH Panitia -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Inti Kepengurusan (BPH) HABERJA</div>
                    <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'struktur']) }}" class="small link-accent">
                        Semua Seksi &rarr;
                    </a>
                </div>
                <div class="card-body" style="padding: 16px;">
                    <div class="bph-list">
                        @forelse($panitias->where('seksi', 'Badan Pengurus Harian (BPH)') as $p)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $p->telepon ?? '');
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                            @endphp
                            <div class="bph-member-row">
                                <div class="d-flex align-items-center gap-3" style="min-width: 0; flex: 1;">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($p->nama, 0, 1)) }}
                                    </div>
                                    <div style="min-width: 0; flex: 1;">
                                        <div class="member-name">{{ $p->nama }}</div>
                                        <div class="member-title">{{ $p->jabatan }}</div>
                                    </div>
                                </div>
                                @if($cleanWa)
                                    <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="btn btn-outline btn-sm wa-btn" title="Chat WhatsApp">
                                        💬 <span class="hide-xs">WA</span>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="text-muted text-center py-4">Data pengurus belum tersedia.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- TAB 2: STRUKTUR PANITIA HABERJA            -->
    <!-- ========================================== -->
    @if($activeTab === 'struktur')
        @php
            $penasihatMembers = $panitias->filter(function($p) {
                $lower = strtolower($p->seksi);
                return str_contains($lower, 'penasihat') || str_contains($lower, 'pelindung') || str_contains($lower, 'pendamping');
            });
            $bphMembers = $panitias->filter(function($p) {
                $lower = strtolower($p->seksi);
                return str_contains($lower, 'bph') || str_contains($lower, 'badan pengurus harian') || str_contains($lower, 'inti');
            });
            $seksiGroups = $panitiaBySeksi->reject(function($members, $name) {
                $lower = strtolower($name);
                return str_contains($lower, 'penasihat') || str_contains($lower, 'pelindung') || str_contains($lower, 'pendamping') || str_contains($lower, 'bph') || str_contains($lower, 'badan pengurus harian') || str_contains($lower, 'inti');
            });
        @endphp

        <!-- INTRO & STATS SUMMARY BANNER -->
        <div class="card mb-3 info-highlight-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="info-icon-badge">🏛️</div>
                        <div>
                            <div class="fw-bold" style="font-size: 13.5px; color: var(--primary);">
                                Struktur Kepanitiaan Hari-Hari Besar Gereja (HABERJA) GEMINDO Kawan Kasih
                            </div>
                            <div class="text-muted" style="font-size: 12px; margin-top: 2px;">
                                Ditetapkan oleh Majelis Jemaat untuk mengkoordinir perayaan Paskah, HUT Gereja, serta Natal &amp; Tahun Baru.
                            </div>
                        </div>
                    </div>
                    <div class="panitia-quick-stats">
                        <div class="panitia-stat-item">
                            <span class="stat-num">{{ $panitias->count() }}</span>
                            <span class="stat-lbl">Personil</span>
                        </div>
                        <div class="panitia-stat-item">
                            <span class="stat-num">{{ $bphMembers->count() }}</span>
                            <span class="stat-lbl">BPH Inti</span>
                        </div>
                        <div class="panitia-stat-item">
                            <span class="stat-num">{{ count($seksiGroups) }}</span>
                            <span class="stat-lbl">Seksi Pelayanan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUICK SEKSI FILTER CHIPS -->
        <div class="seksi-chips-wrapper mb-3">
            <button type="button" class="seksi-chip active" onclick="filterSeksi('all', this)">
                ✨ Semua ({{ $panitias->count() }})
            </button>
            @if($penasihatMembers->count() > 0)
                <button type="button" class="seksi-chip" onclick="filterSeksi('penasihat', this)">
                    🕊️ Penasihat ({{ $penasihatMembers->count() }})
                </button>
            @endif
            @if($bphMembers->count() > 0)
                <button type="button" class="seksi-chip" onclick="filterSeksi('bph', this)">
                    👑 BPH Inti ({{ $bphMembers->count() }})
                </button>
            @endif
            @foreach($seksiGroups as $seksiName => $members)
                @php
                    $seksiSlug = Str::slug($seksiName);
                @endphp
                <button type="button" class="seksi-chip" onclick="filterSeksi('{{ $seksiSlug }}', this)">
                    @if(str_contains(strtolower($seksiName), 'acara')) 📖
                    @elseif(str_contains(strtolower($seksiName), 'dana')) 💰
                    @elseif(str_contains(strtolower($seksiName), 'perlengkapan') || str_contains(strtolower($seksiName), 'dekorasi')) 🎪
                    @elseif(str_contains(strtolower($seksiName), 'konsumsi')) 🍱
                    @elseif(str_contains(strtolower($seksiName), 'publikasi') || str_contains(strtolower($seksiName), 'multimedia')) 📡
                    @elseif(str_contains(strtolower($seksiName), 'keamanan')) 🛡️
                    @elseif(str_contains(strtolower($seksiName), 'diakonia')) ❤️
                    @else 👥 @endif
                    {{ $seksiName }} ({{ $members->count() }})
                </button>
            @endforeach
        </div>

        <!-- TIER 1: PELINDUNG & PENASIHAT ROHANI -->
        @if($penasihatMembers->count() > 0)
            <div class="card mb-4 seksi-group-card penasihat-card-tier" data-seksi="penasihat">
                <div class="card-header d-flex justify-content-between align-items-center penasihat-header">
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size: 20px;">🕊️</span>
                        <div>
                            <div class="card-title" style="color: var(--primary-dark); font-size: 15px; margin: 0;">
                                Pelindung &amp; Penasihat Rohani Majelis Jemaat
                            </div>
                            <div style="font-size: 11px; color: var(--accent-dark); font-weight: 500;">
                                Memberikan pendampingan pastoral, pengawasan teologis, dan restu pelayanan
                            </div>
                        </div>
                    </div>
                    <span class="badge badge-gold" style="font-size: 11px; font-weight: 700;">
                        {{ $penasihatMembers->count() }} Penasihat
                    </span>
                </div>
                <div class="card-body" style="padding: 16px;">
                    <div class="panitia-cards-grid">
                        @foreach($penasihatMembers as $m)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $m->telepon ?? '');
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                            @endphp
                            <div class="member-card member-card-penasihat">
                                <div class="member-card-body">
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        <div class="member-avatar-penasihat">
                                            ✝
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <div class="member-full-name">{{ $m->nama }}</div>
                                            <div class="member-role-title">{{ $m->jabatan }}</div>
                                            @if($m->event)
                                                <span class="badge badge-info" style="font-size: 9px; margin-top: 3px;">{{ $m->event->nama }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($m->tugas_pokok)
                                        <div class="member-task-box">
                                            <span class="task-label">Peran:</span> {{ $m->tugas_pokok }}
                                        </div>
                                    @endif
                                </div>
                                <div class="member-card-footer">
                                    <div>
                                        @if($cleanWa)
                                            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="contact-link" title="Hubungi via WhatsApp">
                                                💬 <span>{{ $m->telepon }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 11px;">-</span>
                                        @endif
                                    </div>
                                    @if($canManage)
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editPanitia({{ json_encode($m) }})">✏️</button>
                                            <form action="{{ route('haberja.panitia.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus personil {{ $m->nama }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm action-btn action-del">🗑️</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- TIER 2: BADAN PENGURUS HARIAN (BPH) -->
        @if($bphMembers->count() > 0)
            <div class="card mb-4 seksi-group-card bph-card-tier" data-seksi="bph">
                <div class="card-header d-flex justify-content-between align-items-center bph-header">
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size: 20px;">👑</span>
                        <div>
                            <div class="card-title" style="color: var(--primary); font-size: 15px; margin: 0;">
                                Badan Pengurus Harian (BPH) HABERJA
                            </div>
                            <div style="font-size: 11px; color: var(--text-muted); font-weight: 500;">
                                Pimpinan eksekutif yang bertanggung jawab atas seluruh kelancaran rangkaian acara
                            </div>
                        </div>
                    </div>
                    <span class="badge badge-gold" style="font-size: 11px; font-weight: 700;">
                        {{ $bphMembers->count() }} Pengurus
                    </span>
                </div>
                <div class="card-body" style="padding: 16px;">
                    <div class="panitia-cards-grid">
                        @foreach($bphMembers as $m)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $m->telepon ?? '');
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                            @endphp
                            <div class="member-card member-card-bph">
                                <div class="member-card-body">
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        <div class="member-avatar-lg">
                                            {{ strtoupper(substr($m->nama, 0, 1)) }}
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <div class="member-full-name">{{ $m->nama }}</div>
                                            <div class="member-role-title">{{ $m->jabatan }}</div>
                                            @if($m->event)
                                                <span class="badge badge-info" style="font-size: 9px; margin-top: 3px;">{{ $m->event->nama }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($m->tugas_pokok)
                                        <div class="member-task-box">
                                            <span class="task-label">Tugas:</span> {{ $m->tugas_pokok }}
                                        </div>
                                    @endif
                                </div>
                                <div class="member-card-footer">
                                    <div>
                                        @if($cleanWa)
                                            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="contact-link" title="Hubungi via WhatsApp">
                                                💬 <span>{{ $m->telepon }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 11px;">-</span>
                                        @endif
                                    </div>
                                    @if($canManage)
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editPanitia({{ json_encode($m) }})">✏️</button>
                                            <form action="{{ route('haberja.panitia.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus personil {{ $m->nama }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm action-btn action-del">🗑️</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- TIER 3: SEKSI-SEKSI PELAYANAN TEKNIS -->
        @foreach($seksiGroups as $seksiName => $members)
            @php
                $seksiSlug = Str::slug($seksiName);
            @endphp
            <div class="card mb-3 seksi-group-card" data-seksi="{{ $seksiSlug }}">
                <div class="card-header d-flex justify-content-between align-items-center seksi-header">
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size: 18px;">
                            @if(str_contains(strtolower($seksiName), 'acara')) 📖
                            @elseif(str_contains(strtolower($seksiName), 'dana')) 💰
                            @elseif(str_contains(strtolower($seksiName), 'perlengkapan') || str_contains(strtolower($seksiName), 'dekorasi')) 🎪
                            @elseif(str_contains(strtolower($seksiName), 'konsumsi')) 🍱
                            @elseif(str_contains(strtolower($seksiName), 'publikasi') || str_contains(strtolower($seksiName), 'multimedia')) 📡
                            @elseif(str_contains(strtolower($seksiName), 'keamanan')) 🛡️
                            @elseif(str_contains(strtolower($seksiName), 'diakonia')) ❤️
                            @else 👥 @endif
                        </span>
                        <div class="card-title" style="font-size: 14.5px;">{{ $seksiName }}</div>
                    </div>
                    <span class="badge badge-secondary" style="font-size: 11px;">{{ $members->count() }} Personil</span>
                </div>
                <div class="card-body" style="padding: 14px;">
                    <div class="panitia-cards-grid">
                        @foreach($members as $m)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $m->telepon ?? '');
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                                $isKoordinator = str_contains(strtolower($m->jabatan), 'koordinator') || str_contains(strtolower($m->jabatan), 'ketua seksi');
                            @endphp
                            <div class="member-card {{ $isKoordinator ? 'member-card-koordinator' : '' }}">
                                <div class="member-card-body">
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        <div class="member-avatar-lg {{ $isKoordinator ? 'avatar-koordinator' : '' }}">
                                            {{ strtoupper(substr($m->nama, 0, 1)) }}
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <div class="member-full-name">{{ $m->nama }}</div>
                                                @if($isKoordinator)
                                                    <span class="badge badge-gold" style="font-size: 9px; padding: 2px 6px;">Koordinator</span>
                                                @endif
                                            </div>
                                            <div class="member-role-title">{{ $m->jabatan }}</div>
                                            @if($m->event)
                                                <span class="badge badge-info" style="font-size: 9px; margin-top: 3px;">{{ $m->event->nama }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($m->tugas_pokok)
                                        <div class="member-task-box">
                                            <span class="task-label">Tugas:</span> {{ $m->tugas_pokok }}
                                        </div>
                                    @endif
                                </div>

                                <div class="member-card-footer">
                                    <div>
                                        @if($cleanWa)
                                            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="contact-link" title="Hubungi via WhatsApp">
                                                💬 <span>{{ $m->telepon }}</span>
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 11px;">-</span>
                                        @endif
                                    </div>
                                    @if($canManage)
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editPanitia({{ json_encode($m) }})">
                                                ✏️
                                            </button>
                                            <form action="{{ route('haberja.panitia.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus personil {{ $m->nama }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- ========================================== -->
    <!-- TAB 3: PLANNING PENCARIAN DANA             -->
    <!-- ========================================== -->
    @if($activeTab === 'dana')
        <!-- SUMMARY STRIP & KPI CARDS -->
        <div class="haberja-kpi-grid mb-3">
            <div class="card haberja-kpi-card kpi-accent">
                <div class="kpi-header">
                    <span class="kpi-label">Target Usaha Dana</span>
                    <span class="kpi-icon">🎯</span>
                </div>
                <div class="kpi-value">Rp {{ number_format($totalTargetDana, 0, ',', '.') }}</div>
                <div class="kpi-desc">Akumulasi target seluruh program aksi dana</div>
            </div>

            <div class="card haberja-kpi-card kpi-success">
                <div class="kpi-header">
                    <span class="kpi-label">Realisasi Terkumpul</span>
                    <span class="kpi-icon">✅</span>
                </div>
                <div class="kpi-value kpi-val-success">Rp {{ number_format($totalRealisasiDana, 0, ',', '.') }}</div>
                <div class="kpi-progress-wrap">
                    <div class="kpi-progress-bar">
                        <div class="kpi-progress-fill" style="width: {{ $persenDana }}%;"></div>
                    </div>
                    <span class="kpi-progress-pct">{{ $persenDana }}%</span>
                </div>
            </div>

            <div class="card haberja-kpi-card kpi-warning">
                <div class="kpi-header">
                    <span class="kpi-label">Sisa Target</span>
                    <span class="kpi-icon">⏳</span>
                </div>
                <div class="kpi-value kpi-val-warning">Rp {{ number_format($sisaTargetDana, 0, ',', '.') }}</div>
                <div class="kpi-desc">Kekurangan target yang sedang dipacu</div>
            </div>
        </div>

        <!-- PROGRESS BAR OVERALL MILESTONE -->
        <div class="card mb-3 milestone-banner-card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <div class="fw-bold" style="font-size: 13px; color: var(--primary);">
                        Milestone Capaian Aksi Usaha Dana
                    </div>
                    <div style="font-size: 12px; font-weight: 700; color: {{ $persenDana >= 100 ? 'var(--success)' : 'var(--accent-dark)' }};">
                        Rp {{ number_format($totalRealisasiDana, 0, ',', '.') }} / Rp {{ number_format($totalTargetDana, 0, ',', '.') }} ({{ $persenDana }}%)
                    </div>
                </div>
                <div class="milestone-bar-wrap">
                    <div class="milestone-bar-fill" style="width: {{ $persenDana }}%;"></div>
                </div>
            </div>
        </div>

        <!-- PROGRAM STATUS FILTER TABS -->
        <div class="dana-filter-wrapper mb-3">
            <button type="button" class="dana-filter-btn active" onclick="filterDanaStatus('all', this)">
                ✨ Semua ({{ $danaPlans->count() }})
            </button>
            <button type="button" class="dana-filter-btn" onclick="filterDanaStatus('berjalan', this)">
                ⚡ Berjalan ({{ $danaPlans->where('status', 'berjalan')->count() }})
            </button>
            <button type="button" class="dana-filter-btn" onclick="filterDanaStatus('tercapai', this)">
                ✅ Tercapai / Selesai ({{ $danaPlans->whereIn('status', ['tercapai', 'selesai'])->count() }})
            </button>
            <button type="button" class="dana-filter-btn" onclick="filterDanaStatus('rencana', this)">
                📅 Rencana ({{ $danaPlans->where('status', 'rencana')->count() }})
            </button>
        </div>

        <!-- LIST OF FUNDRAISING PROGRAMS -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Rencana &amp; Realisasi Program Usaha Dana</div>
                <span class="badge badge-gold">{{ $danaPlans->count() }} Program</span>
            </div>

            <!-- DESKTOP TABLE VIEW -->
            <div class="card-body p-0 hide-mobile-table">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Program &amp; Strategi Dana</th>
                                <th style="white-space: nowrap; text-align: right;">Target Dana</th>
                                <th style="white-space: nowrap; text-align: right;">Realisasi Masuk</th>
                                <th style="width: 140px; text-align: center;">Capaian (%)</th>
                                <th>Jadwal Pelaksanaan</th>
                                <th>Penanggung Jawab</th>
                                <th>Status</th>
                                @if($canManage)
                                    <th style="width: 100px; text-align: center;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($danaPlans as $dp)
                                @php
                                    $stClass = in_array($dp->status, ['tercapai', 'selesai']) ? 'tercapai' : ($dp->status === 'berjalan' ? 'berjalan' : 'rencana');
                                @endphp
                                <tr class="dana-table-row" data-status="{{ $stClass }}">
                                    <td>
                                        <div class="fw-bold" style="font-size: 13.5px; color: var(--primary);">{{ $dp->nama_program }}</div>
                                        @if($dp->event)
                                            <span class="badge badge-info" style="font-size: 9.5px; margin: 3px 0;">{{ $dp->event->nama }}</span>
                                        @endif
                                        <div class="text-muted small" style="font-size: 11.5px; line-height: 1.4; margin-top: 3px;">
                                            {{ $dp->deskripsi }}
                                        </div>
                                        @if($dp->catatan)
                                            <div style="font-size: 11px; color: var(--accent-dark); font-style: italic; margin-top: 4px;">
                                                💡 {{ $dp->catatan }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="white-space: nowrap; font-weight: 600; text-align: right;">
                                        Rp {{ number_format($dp->target_dana, 0, ',', '.') }}
                                    </td>
                                    <td style="white-space: nowrap; font-weight: 700; color: var(--success); text-align: right;">
                                        Rp {{ number_format($dp->realisasi_dana, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="flex: 1; background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden; min-width: 60px;">
                                                <div style="width: {{ $dp->persentase }}%; background: {{ $dp->persentase >= 100 ? 'var(--success)' : 'var(--accent)' }}; height: 100%;"></div>
                                            </div>
                                            <span style="font-size: 11px; font-weight: 700; color: {{ $dp->persentase >= 100 ? 'var(--success)' : 'var(--primary)' }};">
                                                {{ $dp->persentase }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td style="font-size: 12px; white-space: nowrap;">
                                        {{ $dp->tanggal_mulai ? $dp->tanggal_mulai->format('d/m/Y') : '-' }} 
                                        @if($dp->tanggal_selesai) s/d {{ $dp->tanggal_selesai->format('d/m/Y') }} @endif
                                    </td>
                                    <td style="font-size: 12px; font-weight: 500;">
                                        {{ $dp->penanggung_jawab ?? '-' }}
                                    </td>
                                    <td>
                                        @if($dp->status === 'selesai' || $dp->status === 'tercapai')
                                            <span class="badge badge-success">{{ ucfirst($dp->status) }}</span>
                                        @elseif($dp->status === 'berjalan')
                                            <span class="badge badge-gold">Sedang Berjalan</span>
                                        @else
                                            <span class="badge badge-secondary">Rencana</span>
                                        @endif
                                    </td>
                                    @if($canManage)
                                        <td style="text-align: center; white-space: nowrap;">
                                            <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editDana({{ json_encode($dp) }})">
                                                ✏️
                                            </button>
                                            <form action="{{ route('haberja.dana.destroy', $dp->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus program {{ $dp->nama_program }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $canManage ? 8 : 7 }}" class="text-center py-4 text-muted">
                                        Belum ada data program pencarian dana.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr style="background: var(--bg); font-weight: 700;">
                                <td>TOTAL USAHA DANA:</td>
                                <td style="text-align: right; color: var(--primary);">Rp {{ number_format($totalTargetDana, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: var(--success);">Rp {{ number_format($totalRealisasiDana, 0, ',', '.') }}</td>
                                <td style="text-align: center; color: {{ $persenDana >= 100 ? 'var(--success)' : 'var(--accent-dark)' }};">{{ $persenDana }}%</td>
                                <td colspan="{{ $canManage ? 4 : 3 }}">Sisa Target: <strong>Rp {{ number_format($sisaTargetDana, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- MOBILE CARDS VIEW (CLEAN NATIVE APP STYLE) -->
            <div class="card-body p-2 show-mobile-cards">
                @forelse($danaPlans as $dp)
                    @php
                        $stClass = in_array($dp->status, ['tercapai', 'selesai']) ? 'tercapai' : ($dp->status === 'berjalan' ? 'berjalan' : 'rencana');
                    @endphp
                    <div class="mobile-program-card dana-mobile-card" data-status="{{ $stClass }}">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div style="flex: 1; min-width: 0;">
                                <div class="prog-title">{{ $dp->nama_program }}</div>
                                @if($dp->event)
                                    <span class="badge badge-info" style="font-size: 9.5px; margin-top: 3px;">{{ $dp->event->nama }}</span>
                                @endif
                            </div>
                            <span class="badge {{ $dp->status === 'tercapai' || $dp->status === 'selesai' ? 'badge-success' : ($dp->status === 'berjalan' ? 'badge-gold' : 'badge-secondary') }}" style="font-size: 10px; flex-shrink: 0;">
                                {{ ucfirst($dp->status) }}
                            </span>
                        </div>

                        @if($dp->deskripsi)
                            <div class="prog-desc">{{ $dp->deskripsi }}</div>
                        @endif

                        <!-- Financial Tiles (Target vs Realisasi) -->
                        <div class="prog-stat-box">
                            <div class="prog-tiles-grid mb-2">
                                <div class="prog-tile">
                                    <div class="prog-tile-label">Target Dana</div>
                                    <div class="prog-tile-val">Rp {{ number_format($dp->target_dana, 0, ',', '.') }}</div>
                                </div>
                                <div class="prog-tile">
                                    <div class="prog-tile-label">Realisasi Masuk</div>
                                    <div class="prog-tile-val text-success">Rp {{ number_format($dp->realisasi_dana, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="prog-bar-wrap">
                                <div class="prog-bar-fill" style="width: {{ $dp->persentase }}%;"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1" style="font-size: 11px;">
                                <span class="text-muted">Sisa: Rp {{ number_format(max(0, $dp->target_dana - $dp->realisasi_dana), 0, ',', '.') }}</span>
                                <span style="font-weight: 700; color: {{ $dp->persentase >= 100 ? 'var(--success)' : 'var(--accent-dark)' }};">
                                    {{ $dp->persentase }}% Tercapai
                                </span>
                            </div>
                        </div>

                        @if($dp->catatan)
                            <div style="font-size: 11px; color: var(--accent-dark); font-style: italic; margin-bottom: 8px;">
                                💡 {{ $dp->catatan }}
                            </div>
                        @endif

                        <!-- Footer Details & Actions -->
                        <div class="prog-footer">
                            <div class="prog-meta">
                                <div>👤 <strong>{{ $dp->penanggung_jawab ?? '-' }}</strong></div>
                                <div>📅 {{ $dp->tanggal_mulai ? $dp->tanggal_mulai->format('d/m/y') : '-' }} @if($dp->tanggal_selesai) s/d {{ $dp->tanggal_selesai->format('d/m/y') }} @endif</div>
                            </div>
                            @if($canManage)
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editDana({{ json_encode($dp) }})">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('haberja.dana.destroy', $dp->id) }}" method="POST" onsubmit="return confirm('Hapus program {{ $dp->nama_program }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-muted text-center py-4">Belum ada program dana.</div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- TAB 4: BUDGETING & RAB                     -->
    <!-- ========================================== -->
    @if($activeTab === 'budget')
        <!-- FINANCIAL RECAP CARDS -->
        <div class="haberja-kpi-grid mb-3">
            <div class="card haberja-kpi-card kpi-burgundy">
                <div class="kpi-header">
                    <span class="kpi-label">Total Belanja (Pengeluaran)</span>
                    <span class="kpi-icon">📉</span>
                </div>
                <div class="kpi-value kpi-val-burgundy">Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}</div>
                <div class="kpi-desc">Realisasi: <strong>Rp {{ number_format($totalRealisasiPengeluaran, 0, ',', '.') }}</strong></div>
            </div>

            <div class="card haberja-kpi-card kpi-success">
                <div class="kpi-header">
                    <span class="kpi-label">Total Sumber Pemasukan</span>
                    <span class="kpi-icon">📈</span>
                </div>
                <div class="kpi-value kpi-val-success">Rp {{ number_format($totalRencanaPemasukan, 0, ',', '.') }}</div>
                <div class="kpi-desc">Realisasi: <strong>Rp {{ number_format($totalRealisasiPemasukan, 0, ',', '.') }}</strong></div>
            </div>

            <div class="card haberja-kpi-card kpi-accent">
                <div class="kpi-header">
                    <span class="kpi-label">Keseimbangan Anggaran</span>
                    <span class="kpi-icon">⚖️</span>
                </div>
                @php $selisihRAB = $totalRencanaPemasukan - $totalTargetRAB; @endphp
                <div class="kpi-value" style="color: {{ $selisihRAB >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                    {{ $selisihRAB >= 0 ? '+' : '' }} Rp {{ number_format($selisihRAB, 0, ',', '.') }}
                </div>
                <div class="kpi-desc">{{ $selisihRAB >= 0 ? 'Anggaran berimbang / surplus' : 'Perlu dipacu dari donatur & dana' }}</div>
            </div>
        </div>

        <!-- QUICK CATEGORY TOGGLE (SEMUA / BELANJA / PEMASUKAN) -->
        <div class="budget-toggle-wrapper mb-3">
            <button type="button" class="budget-toggle-btn active" onclick="filterBudgetType('all', this)">
                📑 Semua Pos ({{ $pengeluarans->count() + $pemasukans->count() }})
            </button>
            <button type="button" class="budget-toggle-btn" onclick="filterBudgetType('pengeluaran', this)">
                📉 Belanja / Pengeluaran ({{ $pengeluarans->count() }})
            </button>
            <button type="button" class="budget-toggle-btn" onclick="filterBudgetType('pemasukan', this)">
                📈 Pemasukan / Sumber Dana ({{ $pemasukans->count() }})
            </button>
        </div>

        <!-- 1. SECTION PENGELUARAN (BELANJA) -->
        <div class="card mb-4 budget-section-card" id="sectionPengeluaran">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #fbf0f0 0%, #fff 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size: 18px;">📉</span>
                    <div class="card-title" style="color: var(--burgundy);">RAB Pengeluaran (Kebutuhan Belanja)</div>
                </div>
                <span class="badge badge-danger">{{ $pengeluarans->count() }} Pos Belanja</span>
            </div>

            <!-- DESKTOP TABLE -->
            <div class="card-body p-0 hide-mobile-table">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Pos Seksi</th>
                                <th>Uraian Kebutuhan Belanja</th>
                                <th style="white-space: nowrap;">Volume</th>
                                <th style="white-space: nowrap; text-align: right;">Harga Satuan</th>
                                <th style="white-space: nowrap; text-align: right;">Total Anggaran</th>
                                <th style="white-space: nowrap; text-align: right;">Realisasi</th>
                                <th style="white-space: nowrap; text-align: right;">Sisa Selisih</th>
                                <th>Keterangan</th>
                                @if($canManage)
                                    <th style="width: 90px; text-align: center;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluarans as $bg)
                                <tr>
                                    <td style="font-weight: 600; font-size: 12px; color: var(--primary);">
                                        {{ $bg->seksi }}
                                        @if($bg->event)
                                            <div style="font-size: 9.5px; color: var(--accent-dark);">{{ $bg->event->nama }}</div>
                                        @endif
                                    </td>
                                    <td style="font-weight: 600; font-size: 13px;">
                                        {{ $bg->uraian }}
                                    </td>
                                    <td style="font-size: 12px; white-space: nowrap;">
                                        {{ $bg->volume ?? '-' }}
                                    </td>
                                    <td style="font-size: 12px; white-space: nowrap; text-align: right;">
                                        Rp {{ number_format($bg->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td style="font-weight: 700; white-space: nowrap; color: var(--primary); text-align: right;">
                                        Rp {{ number_format($bg->total_anggaran, 0, ',', '.') }}
                                    </td>
                                    <td style="font-weight: 600; white-space: nowrap; color: var(--burgundy); text-align: right;">
                                        Rp {{ number_format($bg->realisasi, 0, ',', '.') }}
                                    </td>
                                    <td style="font-weight: 600; white-space: nowrap; color: {{ $bg->selisih >= 0 ? 'var(--success)' : 'var(--danger)' }}; text-align: right;">
                                        Rp {{ number_format($bg->selisih, 0, ',', '.') }}
                                    </td>
                                    <td style="font-size: 11.5px; color: var(--text-muted);">
                                        {{ $bg->keterangan ?? '-' }}
                                    </td>
                                    @if($canManage)
                                        <td style="text-align: center; white-space: nowrap;">
                                            <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editBudget({{ json_encode($bg) }})">
                                                ✏️
                                            </button>
                                            <form action="{{ route('haberja.budget.destroy', $bg->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus item belanja {{ $bg->uraian }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $canManage ? 9 : 8 }}" class="text-center py-4 text-muted">
                                        Belum ada item anggaran pengeluaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr style="background: var(--bg); font-weight: 700;">
                                <td colspan="4" style="text-align: right;">TOTAL PENGELUARAN:</td>
                                <td style="color: var(--primary); text-align: right;">Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}</td>
                                <td style="color: var(--burgundy); text-align: right;">Rp {{ number_format($totalRealisasiPengeluaran, 0, ',', '.') }}</td>
                                <td style="color: var(--success); text-align: right;">Rp {{ number_format($totalTargetRAB - $totalRealisasiPengeluaran, 0, ',', '.') }}</td>
                                <td colspan="{{ $canManage ? 2 : 1 }}"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- MOBILE CARDS VIEW FOR PENGELUARAN -->
            <div class="card-body p-2 show-mobile-cards">
                @forelse($pengeluarans as $bg)
                    <div class="mobile-budget-card">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                            <span class="badge badge-secondary" style="font-size: 10px;">{{ $bg->seksi }}</span>
                            @if($bg->event)
                                <span class="badge badge-info" style="font-size: 9px;">{{ $bg->event->nama }}</span>
                            @endif
                        </div>
                        <div class="budget-item-title">{{ $bg->uraian }}</div>
                        @if($bg->volume)
                            <div class="budget-item-unit">
                                Volume: <strong>{{ $bg->volume }}</strong> 
                                @if($bg->harga_satuan > 0)
                                    @ Rp {{ number_format($bg->harga_satuan, 0, ',', '.') }}
                                @endif
                            </div>
                        @endif

                        <div class="budget-amount-grid mt-2">
                            <div class="budget-amount-col">
                                <div class="b-lbl">Anggaran</div>
                                <div class="b-val text-primary">Rp {{ number_format($bg->total_anggaran, 0, ',', '.') }}</div>
                            </div>
                            <div class="budget-amount-col">
                                <div class="b-lbl">Realisasi</div>
                                <div class="b-val text-burgundy">Rp {{ number_format($bg->realisasi, 0, ',', '.') }}</div>
                            </div>
                            <div class="budget-amount-col">
                                <div class="b-lbl">Selisih</div>
                                <div class="b-val" style="color: {{ $bg->selisih >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                                    Rp {{ number_format($bg->selisih, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        @if($bg->keterangan)
                            <div class="budget-item-notes mt-2">
                                📌 {{ $bg->keterangan }}
                            </div>
                        @endif

                        @if($canManage)
                            <div class="d-flex justify-content-end gap-1 mt-2 pt-2 border-top">
                                <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editBudget({{ json_encode($bg) }})">
                                    ✏️ Edit
                                </button>
                                <form action="{{ route('haberja.budget.destroy', $bg->id) }}" method="POST" onsubmit="return confirm('Hapus item belanja {{ $bg->uraian }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-muted text-center py-4">Belum ada item anggaran pengeluaran.</div>
                @endforelse
            </div>
        </div>

        <!-- 2. SECTION PEMASUKAN (SUMBER DANA) -->
        <div class="card mb-4 budget-section-card" id="sectionPemasukan">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #edf8f1 0%, #fff 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size: 18px;">📈</span>
                    <div class="card-title" style="color: var(--success);">Rencana Sumber Penerimaan / Pemasukan Dana</div>
                </div>
                <span class="badge badge-success">{{ $pemasukans->count() }} Sumber Dana</span>
            </div>

            <!-- DESKTOP TABLE -->
            <div class="card-body p-0 hide-mobile-table">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Kategori Sumber</th>
                                <th>Uraian Sumber Dana</th>
                                <th style="white-space: nowrap; text-align: right;">Target Penerimaan</th>
                                <th style="white-space: nowrap; text-align: right;">Realisasi Masuk</th>
                                <th style="white-space: nowrap; text-align: right;">Sisa Target</th>
                                <th>Keterangan</th>
                                @if($canManage)
                                    <th style="width: 90px; text-align: center;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemasukans as $pm)
                                <tr>
                                    <td style="font-weight: 600; font-size: 12px; color: var(--primary);">
                                        {{ $pm->seksi }}
                                        @if($pm->event)
                                            <div style="font-size: 9.5px; color: var(--accent-dark);">{{ $pm->event->nama }}</div>
                                        @endif
                                    </td>
                                    <td style="font-weight: 600; font-size: 13px;">
                                        {{ $pm->uraian }}
                                    </td>
                                    <td style="font-weight: 700; white-space: nowrap; color: var(--primary); text-align: right;">
                                        Rp {{ number_format($pm->total_anggaran, 0, ',', '.') }}
                                    </td>
                                    <td style="font-weight: 700; white-space: nowrap; color: var(--success); text-align: right;">
                                        Rp {{ number_format($pm->realisasi, 0, ',', '.') }}
                                    </td>
                                    <td style="font-weight: 600; white-space: nowrap; color: {{ $pm->selisih > 0 ? 'var(--warning)' : 'var(--success)' }}; text-align: right;">
                                        Rp {{ number_format(max(0, $pm->total_anggaran - $pm->realisasi), 0, ',', '.') }}
                                    </td>
                                    <td style="font-size: 11.5px; color: var(--text-muted);">
                                        {{ $pm->keterangan ?? '-' }}
                                    </td>
                                    @if($canManage)
                                        <td style="text-align: center; white-space: nowrap;">
                                            <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editBudget({{ json_encode($pm) }})">
                                                ✏️
                                            </button>
                                            <form action="{{ route('haberja.budget.destroy', $pm->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus penerimaan {{ $pm->uraian }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $canManage ? 7 : 6 }}" class="text-center py-4 text-muted">
                                        Belum ada item rencana pemasukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr style="background: var(--bg); font-weight: 700;">
                                <td colspan="2" style="text-align: right;">TOTAL ESTIMASI PEMASUKAN:</td>
                                <td style="color: var(--primary); text-align: right;">Rp {{ number_format($totalRencanaPemasukan, 0, ',', '.') }}</td>
                                <td style="color: var(--success); text-align: right;">Rp {{ number_format($totalRealisasiPemasukan, 0, ',', '.') }}</td>
                                <td style="color: var(--warning); text-align: right;">Rp {{ number_format(max(0, $totalRencanaPemasukan - $totalRealisasiPemasukan), 0, ',', '.') }}</td>
                                <td colspan="{{ $canManage ? 2 : 1 }}"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- MOBILE CARDS VIEW FOR PEMASUKAN -->
            <div class="card-body p-2 show-mobile-cards">
                @forelse($pemasukans as $pm)
                    @php
                        $pctPm = $pm->total_anggaran > 0 ? min(100, round(($pm->realisasi / $pm->total_anggaran) * 100, 1)) : 0;
                    @endphp
                    <div class="mobile-budget-card">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                            <span class="badge badge-success" style="font-size: 10px;">{{ $pm->seksi }}</span>
                            @if($pm->event)
                                <span class="badge badge-info" style="font-size: 9px;">{{ $pm->event->nama }}</span>
                            @endif
                        </div>
                        <div class="budget-item-title">{{ $pm->uraian }}</div>

                        <div class="budget-amount-grid mt-2">
                            <div class="budget-amount-col">
                                <div class="b-lbl">Target</div>
                                <div class="b-val text-primary">Rp {{ number_format($pm->total_anggaran, 0, ',', '.') }}</div>
                            </div>
                            <div class="budget-amount-col">
                                <div class="b-lbl">Terkumpul</div>
                                <div class="b-val text-success">Rp {{ number_format($pm->realisasi, 0, ',', '.') }}</div>
                            </div>
                            <div class="budget-amount-col">
                                <div class="b-lbl">Sisa</div>
                                <div class="b-val text-warning">Rp {{ number_format(max(0, $pm->total_anggaran - $pm->realisasi), 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="prog-bar-wrap mt-2">
                            <div class="prog-bar-fill" style="width: {{ $pctPm }}%;"></div>
                        </div>
                        <div class="text-end mt-1" style="font-size: 10px; font-weight: 700; color: {{ $pctPm >= 100 ? 'var(--success)' : 'var(--accent-dark)' }};">
                            {{ $pctPm }}% Terkumpul
                        </div>

                        @if($pm->keterangan)
                            <div class="budget-item-notes mt-2">
                                📌 {{ $pm->keterangan }}
                            </div>
                        @endif

                        @if($canManage)
                            <div class="d-flex justify-content-end gap-1 mt-2 pt-2 border-top">
                                <button type="button" class="btn btn-outline btn-sm action-btn" onclick="editBudget({{ json_encode($pm) }})">
                                    ✏️ Edit
                                </button>
                                <form action="{{ route('haberja.budget.destroy', $pm->id) }}" method="POST" onsubmit="return confirm('Hapus penerimaan {{ $pm->uraian }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm action-btn action-del">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-muted text-center py-4">Belum ada item rencana pemasukan.</div>
                @endforelse
            </div>
        </div>
    @endif

</div>

<!-- ========================================== -->
<!-- MODALS FOR MANAGEMENT (ADMIN / MAJELIS)    -->
<!-- ========================================== -->
@if($canManage)
    <!-- Modal Tambah/Edit Panitia -->
    <div id="modalTambahPanitia" class="custom-modal" style="display: none;">
        <div class="modal-backdrop" onclick="closeModal('modalTambahPanitia')"></div>
        <div class="modal-dialog">
            <form id="formPanitia" action="{{ route('haberja.panitia.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="panitiaMethod" value="POST">
                <div class="modal-header">
                    <h3 id="panitiaModalTitle" class="modal-title">Tambah Personil Panitia HABERJA</h3>
                    <button type="button" class="btn-close" onclick="closeModal('modalTambahPanitia')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="form-label">Terkait Acara:</label>
                        <select name="event_id" id="panitia_event_id" class="form-control">
                            <option value="">-- Panitia Induk / Semua Acara --</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Seksi / Bidang: *</label>
                        <select name="seksi" id="panitia_seksi" class="form-control" required>
                            <option value="Badan Pengurus Harian (BPH)">Badan Pengurus Harian (BPH)</option>
                            <option value="Penasihat &amp; Pendamping">Penasihat &amp; Pendamping</option>
                            <option value="Seksi Acara &amp; Ibadah">Seksi Acara &amp; Ibadah</option>
                            <option value="Seksi Usaha Dana">Seksi Usaha Dana</option>
                            <option value="Seksi Perlengkapan &amp; Dekorasi">Seksi Perlengkapan &amp; Dekorasi</option>
                            <option value="Seksi Konsumsi">Seksi Konsumsi</option>
                            <option value="Seksi Publikasi &amp; Multimedia">Seksi Publikasi &amp; Multimedia</option>
                            <option value="Seksi Keamanan &amp; Parkir">Seksi Keamanan &amp; Parkir</option>
                            <option value="Seksi Diakonia &amp; Aksi Kasih">Seksi Diakonia &amp; Aksi Kasih</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Nama Lengkap &amp; Gelar: *</label>
                        <input type="text" name="nama" id="panitia_nama" class="form-control" required placeholder="Contoh: Daniel Sihombing, S.T.">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Jabatan dalam Panitia: *</label>
                        <input type="text" name="jabatan" id="panitia_jabatan" class="form-control" required placeholder="Contoh: Koordinator Seksi Acara">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Nomor WhatsApp / Telepon:</label>
                        <input type="text" name="telepon" id="panitia_telepon" class="form-control" placeholder="0812-xxxx-xxxx">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Tugas Pokok &amp; Tanggung Jawab:</label>
                        <textarea name="tugas_pokok" id="panitia_tugas_pokok" rows="2" class="form-control" placeholder="Rincian tugas dan fungsi koordinasi..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan Tampilan:</label>
                        <input type="number" name="urutan" id="panitia_urutan" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-sm" onclick="closeModal('modalTambahPanitia')">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Personil</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah/Edit Program Dana -->
    <div id="modalTambahDana" class="custom-modal" style="display: none;">
        <div class="modal-backdrop" onclick="closeModal('modalTambahDana')"></div>
        <div class="modal-dialog">
            <form id="formDana" action="{{ route('haberja.dana.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="danaMethod" value="POST">
                <div class="modal-header">
                    <h3 id="danaModalTitle" class="modal-title">Tambah Program Usaha Dana</h3>
                    <button type="button" class="btn-close" onclick="closeModal('modalTambahDana')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="form-label">Terkait Acara:</label>
                        <select name="event_id" id="dana_event_id" class="form-control">
                            <option value="">-- Umum / Semua Acara --</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Nama Program Aksi Dana: *</label>
                        <input type="text" name="nama_program" id="dana_nama_program" class="form-control" required placeholder="Contoh: Aksi Bazaar Makanan Tradisional">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Strategi / Deskripsi Program:</label>
                        <textarea name="deskripsi" id="dana_deskripsi" rows="2" class="form-control" placeholder="Penjelasan teknis pengumpulan dana..."></textarea>
                    </div>
                    <div class="grid-2-col mb-2">
                        <div>
                            <label class="form-label">Target Dana (Rp): *</label>
                            <input type="number" name="target_dana" id="dana_target_dana" class="form-control" required min="0" placeholder="10000000">
                        </div>
                        <div>
                            <label class="form-label">Realisasi Masuk (Rp):</label>
                            <input type="number" name="realisasi_dana" id="dana_realisasi_dana" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="grid-2-col mb-2">
                        <div>
                            <label class="form-label">Tanggal Mulai:</label>
                            <input type="date" name="tanggal_mulai" id="dana_tanggal_mulai" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Tanggal Selesai:</label>
                            <input type="date" name="tanggal_selesai" id="dana_tanggal_selesai" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Penanggung Jawab (PIC):</label>
                        <input type="text" name="penanggung_jawab" id="dana_penanggung_jawab" class="form-control" placeholder="Nama koordinator seksi dana">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Status Program: *</label>
                        <select name="status" id="dana_status" class="form-control" required>
                            <option value="rencana">Rencana</option>
                            <option value="berjalan" selected>Sedang Berjalan</option>
                            <option value="tercapai">Target Tercapai</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan / Evaluasi:</label>
                        <input type="text" name="catatan" id="dana_catatan" class="form-control" placeholder="Catatan perkembangan atau kendala">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-sm" onclick="closeModal('modalTambahDana')">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Program</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah/Edit Budget (RAB) -->
    <div id="modalTambahBudget" class="custom-modal" style="display: none;">
        <div class="modal-backdrop" onclick="closeModal('modalTambahBudget')"></div>
        <div class="modal-dialog">
            <form id="formBudget" action="{{ route('haberja.budget.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="budgetMethod" value="POST">
                <div class="modal-header">
                    <h3 id="budgetModalTitle" class="modal-title">Tambah Item Anggaran (RAB)</h3>
                    <button type="button" class="btn-close" onclick="closeModal('modalTambahBudget')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="form-label">Acara Hari Besar: *</label>
                        <select name="event_id" id="budget_event_id" class="form-control" required>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid-2-col mb-2">
                        <div>
                            <label class="form-label">Tipe Item: *</label>
                            <select name="tipe" id="budget_tipe" class="form-control" required>
                                <option value="pengeluaran">Pengeluaran (Belanja)</option>
                                <option value="pemasukan">Pemasukan (Sumber Dana)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Pos Seksi: *</label>
                            <input type="text" name="seksi" id="budget_seksi" class="form-control" required placeholder="Contoh: Seksi Acara & Ibadah">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Uraian Kebutuhan / Sumber Dana: *</label>
                        <input type="text" name="uraian" id="budget_uraian" class="form-control" required placeholder="Contoh: Konsumsi Ibadah Paskah Subuh">
                    </div>
                    <div class="grid-2-col mb-2">
                        <div>
                            <label class="form-label">Volume (Jumlah/Satuan):</label>
                            <input type="text" name="volume" id="budget_volume" class="form-control" placeholder="Contoh: 350 porsi">
                        </div>
                        <div>
                            <label class="form-label">Harga Satuan (Rp):</label>
                            <input type="number" name="harga_satuan" id="budget_harga_satuan" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="grid-2-col mb-2">
                        <div>
                            <label class="form-label">Total Anggaran (Rp): *</label>
                            <input type="number" name="total_anggaran" id="budget_total_anggaran" class="form-control" required min="0" placeholder="5000000">
                        </div>
                        <div>
                            <label class="form-label">Realisasi (Rp):</label>
                            <input type="number" name="realisasi" id="budget_realisasi" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan / Catatan:</label>
                        <input type="text" name="keterangan" id="budget_keterangan" class="form-control" placeholder="Vendor atau peruntukan spesifik">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-sm" onclick="closeModal('modalTambahBudget')">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Anggaran</button>
                </div>
            </form>
        </div>
    </div>
@endif

<!-- ========================================== -->
<!-- STYLESHEET (CLEAN, MODERN, RESPONSIVE)     -->
<!-- ========================================== -->
<style>
/* Container & Header */
.haberja-container {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
}

.haberja-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
}

.haberja-header-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

/* Hero Card */
.haberja-hero-card {
    background: linear-gradient(135deg, rgba(44,24,16,0.96) 0%, rgba(107,26,46,0.92) 100%);
    color: #fff;
    border: 1px solid var(--accent);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(44,24,16,.15);
}

.haberja-watermark {
    position: absolute;
    right: -20px;
    bottom: -30px;
    font-size: 140px;
    color: rgba(200,148,26,0.06);
    font-family: 'Cinzel', serif;
    pointer-events: none;
    user-select: none;
}

.haberja-hero-body {
    padding: 20px 24px;
    position: relative;
    z-index: 1;
}

.haberja-hero-title {
    font-family: 'EB Garamond', Georgia, serif;
    font-size: 24px;
    color: var(--accent-light);
    margin-bottom: 6px;
    font-weight: 600;
    line-height: 1.25;
}

.haberja-hero-desc {
    font-size: 13px;
    color: #e8d9c0;
    line-height: 1.5;
    margin-bottom: 14px;
    max-width: 800px;
}

/* Event Chips Selector */
.haberja-chips-container {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 12px;
    border-top: 1px solid rgba(255,255,255,0.12);
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: none;
}

.haberja-chips-container::-webkit-scrollbar {
    display: none;
}

.haberja-chips-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--accent-light);
    font-weight: 700;
    flex-shrink: 0;
}

.haberja-chips-scroll {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: none;
}

.haberja-chips-scroll::-webkit-scrollbar {
    display: none;
}

.haberja-chip {
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 20px;
    text-decoration: none;
    background: rgba(255,255,255,0.1);
    color: #fdf6e3;
    border: 1px solid rgba(255,255,255,0.18);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .2s ease;
    flex-shrink: 0;
}

.haberja-chip:hover {
    background: rgba(200,148,26,0.3);
    color: #fff;
    border-color: var(--accent-light);
}

.haberja-chip.active {
    background: var(--accent);
    color: var(--primary-dark);
    font-weight: 700;
    border-color: var(--accent-light);
    box-shadow: 0 2px 8px rgba(0,0,0,.2);
}

/* Horizontal Responsive Tabs */
.haberja-tabs-nav {
    display: flex;
    gap: 6px;
    border-bottom: 2px solid var(--border);
    padding-bottom: 2px;
    overflow-x: auto;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.haberja-tabs-nav::-webkit-scrollbar {
    display: none;
}

.haberja-tab-link {
    padding: 9px 16px;
    font-weight: 600;
    font-size: 13px;
    border-radius: 8px 8px 0 0;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--text-muted);
    transition: all .15s ease;
    border: 1px solid transparent;
    border-bottom: none;
    flex-shrink: 0;
}

.haberja-tab-link:hover {
    color: var(--primary);
    background: rgba(255,255,255,0.5);
}

.haberja-tab-link.active {
    background: var(--card);
    border: 1px solid var(--border);
    border-bottom: 2px solid var(--accent);
    color: var(--primary);
    font-weight: 700;
    box-shadow: 0 -2px 6px rgba(44,24,16,.03);
}

.tab-badge {
    background: #e8d9c0;
    color: var(--primary);
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
}

.tab-badge-gold {
    background: var(--accent);
    color: #fff;
}

.tab-badge-info {
    background: var(--info);
    color: #fff;
}

/* KPI Responsive Grid */
.haberja-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

.haberja-kpi-card {
    padding: 16px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform .2s ease;
}

.haberja-kpi-card:hover {
    transform: translateY(-2px);
}

.kpi-accent { border-left: 4px solid var(--accent); }
.kpi-success { border-left: 4px solid var(--success); }
.kpi-burgundy { border-left: 4px solid var(--burgundy); }
.kpi-warning { border-left: 4px solid var(--warning); }

.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}

.kpi-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--text-muted);
}

.kpi-icon {
    font-size: 16px;
}

.kpi-value {
    font-size: clamp(17px, 2.5vw, 21px);
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
    margin-bottom: 6px;
    word-break: break-word;
}

.kpi-val-success { color: var(--success); }
.kpi-val-burgundy { color: var(--burgundy); }
.kpi-val-warning { color: var(--warning); }

.kpi-desc {
    font-size: 11px;
    color: var(--text-muted);
    line-height: 1.35;
}

.kpi-progress-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 4px;
}

.kpi-progress-bar {
    flex: 1;
    background: #e9ecef;
    height: 6px;
    border-radius: 3px;
    overflow: hidden;
}

.kpi-progress-fill {
    height: 100%;
    background: var(--success);
    border-radius: 3px;
}

.kpi-progress-pct {
    font-size: 11px;
    font-weight: 700;
    color: var(--success);
}

/* 3 Events Grid */
.haberja-events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
    gap: 16px;
}

.haberja-event-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgba(44,24,16,.04);
    transition: transform .2s ease, box-shadow .2s ease;
}

.haberja-event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44,24,16,.08);
}

.event-emoji {
    font-size: 26px;
}

.event-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 4px;
}

.event-verse {
    font-size: 11.5px;
    color: var(--burgundy);
    font-weight: 600;
    margin-bottom: 8px;
    line-height: 1.35;
}

.event-desc {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.45;
    margin-bottom: 12px;
}

.event-card-bottom {
    border-top: 1px dashed var(--border);
    padding-top: 10px;
}

/* Overview Dual-Grid */
.haberja-overview-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 20px;
    align-items: start;
}

.link-accent {
    color: var(--accent-dark);
    font-weight: 600;
    text-decoration: none;
    font-size: 12px;
}

.link-accent:hover {
    text-decoration: underline;
}

.snapshot-list {
    display: flex !important;
    flex-direction: column !important;
    gap: 12px !important;
    width: 100%;
}

.snapshot-card {
    padding: 14px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: #fff;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 1px 3px rgba(44,24,16,.04);
}

.mini-progress {
    background: #e9ecef;
    height: 6px;
    border-radius: 3px;
    overflow: hidden;
    margin-top: 4px;
}

.mini-progress-fill {
    height: 100%;
    background: var(--success);
    border-radius: 3px;
}

/* BPH Snapshot List & Row */
.bph-list {
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
    width: 100%;
}

.bph-member-row {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: #fff;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 1px 3px rgba(44,24,16,.04);
    transition: transform .15s ease;
}

.bph-member-row:hover {
    transform: translateX(2px);
    border-color: var(--accent);
}

.member-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, #4a2818 100%);
    color: var(--accent-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    flex-shrink: 0;
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
}

.member-name {
    font-weight: 700;
    font-size: 13.5px;
    color: var(--primary);
    line-height: 1.3;
    word-break: normal;
}

.member-title {
    font-size: 11.5px;
    color: var(--accent-dark);
    font-weight: 600;
    margin-top: 2px;
}

.wa-btn {
    font-size: 11.5px;
    padding: 5px 10px;
    border-color: #25d366;
    color: #128c7e;
    font-weight: 600;
    background: rgba(37,211,102,0.06);
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.wa-btn:hover {
    background: #25d366;
    color: #fff;
}

/* ========================================== */
/* TAB 2: STRUKTUR PANITIA STYLES             */
/* ========================================== */
.info-highlight-card {
    background: linear-gradient(135deg, rgba(200,148,26,.08), rgba(44,24,16,.03));
    border: 1px dashed var(--accent);
}

.info-icon-badge {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: rgba(200,148,26,0.15);
    color: var(--accent-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.panitia-quick-stats {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.panitia-stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 6px 12px;
    min-width: 65px;
    box-shadow: 0 1px 3px rgba(44,24,16,.04);
}

.stat-num {
    font-size: 16px;
    font-weight: 800;
    color: var(--primary);
    line-height: 1.1;
}

.stat-lbl {
    font-size: 9.5px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    font-weight: 700;
}

.seksi-chips-wrapper {
    display: flex;
    gap: 6px;
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 4px;
    scrollbar-width: none;
}

.seksi-chips-wrapper::-webkit-scrollbar {
    display: none;
}

.seksi-chip {
    padding: 5px 12px;
    font-size: 11.5px;
    font-weight: 600;
    border-radius: 16px;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .15s ease;
    flex-shrink: 0;
}

.seksi-chip:hover {
    border-color: var(--accent);
    color: var(--primary);
}

.seksi-chip.active {
    background: var(--primary);
    color: var(--accent-light);
    border-color: var(--primary-dark);
    font-weight: 700;
}

/* Tier 1: Penasihat */
.penasihat-card-tier {
    border: 1px solid rgba(200,148,26,0.35);
    background: #fffefb;
    box-shadow: 0 2px 8px rgba(200,148,26,0.06);
}

.penasihat-header {
    background: linear-gradient(90deg, #fbf4e6 0%, #fff 100%) !important;
    border-bottom: 1px solid rgba(200,148,26,0.2) !important;
}

.member-card-penasihat {
    border: 1px solid rgba(200,148,26,0.25) !important;
    background: linear-gradient(180deg, #ffffff 0%, #fdfbf7 100%) !important;
}

.member-avatar-penasihat {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #c8941a 0%, #8b1a1a 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 20px;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(200,148,26,0.25);
}

/* Tier 2: BPH */
.bph-card-tier {
    border: 1px solid rgba(107,26,46,0.25);
    background: #fff;
}

.bph-header {
    background: linear-gradient(90deg, #fdf4df 0%, #fff 100%) !important;
    border-bottom: 1px solid rgba(200,148,26,0.2) !important;
}

.member-card-bph {
    border-left: 4px solid var(--accent) !important;
    background: #fffdfa !important;
}

/* Tier 3: Seksi & Koordinator */
.seksi-header {
    background: #faf8f5 !important;
    border-bottom: 1px solid var(--border) !important;
}

.member-card-koordinator {
    border-left: 3px solid var(--accent) !important;
}

.avatar-koordinator {
    background: linear-gradient(135deg, var(--accent-dark) 0%, var(--primary) 100%) !important;
}

.panitia-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
    gap: 14px;
}

.member-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 14px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all .2s ease;
    box-shadow: 0 1px 3px rgba(44,24,16,.03);
}

.member-card:hover {
    box-shadow: 0 3px 8px rgba(44,24,16,.08);
}

.member-avatar-lg {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, #4a2818 100%);
    color: var(--accent-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0,0,0,.12);
}

.member-full-name {
    font-weight: 700;
    font-size: 13.5px;
    color: var(--primary);
    line-height: 1.3;
}

.member-role-title {
    font-size: 11.5px;
    color: var(--accent-dark);
    font-weight: 600;
    margin-top: 2px;
}

.member-task-box {
    font-size: 11.5px;
    color: var(--text-muted);
    background: var(--bg);
    padding: 8px 10px;
    border-radius: 6px;
    line-height: 1.4;
    margin-top: 10px;
}

.task-label {
    font-weight: 700;
    color: var(--primary);
}

.member-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    padding-top: 8px;
    border-top: 1px solid #f2e9dc;
}

.contact-link {
    color: #128c7e;
    text-decoration: none;
    font-weight: 600;
    font-size: 11.5px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.contact-link:hover {
    text-decoration: underline;
}

.action-btn {
    padding: 3px 8px;
    font-size: 11px;
}

.action-del {
    color: var(--danger);
    border-color: rgba(139,26,26,.3);
}

/* ========================================== */
/* TAB 3: PLANNING PENCARIAN DANA STYLES      */
/* ========================================== */
.milestone-banner-card {
    background: linear-gradient(135deg, #fdf9f0 0%, #fff 100%);
    border: 1px solid rgba(200,148,26,0.25);
}

.milestone-bar-wrap {
    background: #e9ecef;
    height: 10px;
    border-radius: 5px;
    overflow: hidden;
}

.milestone-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent) 0%, var(--success) 100%);
    border-radius: 5px;
    transition: width .4s ease;
}

.dana-filter-wrapper, .budget-toggle-wrapper {
    display: flex;
    gap: 6px;
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 2px;
    scrollbar-width: none;
}

.dana-filter-wrapper::-webkit-scrollbar, .budget-toggle-wrapper::-webkit-scrollbar {
    display: none;
}

.dana-filter-btn, .budget-toggle-btn {
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 20px;
    border: 1px solid var(--border);
    background: #fff;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .15s ease;
    flex-shrink: 0;
}

.dana-filter-btn:hover, .budget-toggle-btn:hover {
    border-color: var(--accent);
    color: var(--primary);
}

.dana-filter-btn.active, .budget-toggle-btn.active {
    background: var(--primary);
    color: var(--accent-light);
    border-color: var(--primary-dark);
    font-weight: 700;
}

.show-mobile-cards {
    display: none;
}

.mobile-program-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    box-shadow: 0 1px 3px rgba(44,24,16,.04);
}

.prog-title {
    font-weight: 700;
    font-size: 13.5px;
    color: var(--primary);
    line-height: 1.3;
}

.prog-desc {
    font-size: 11.5px;
    color: var(--text-muted);
    line-height: 1.4;
    margin-bottom: 8px;
}

.prog-stat-box {
    background: var(--bg);
    padding: 8px 10px;
    border-radius: 6px;
    margin-bottom: 10px;
}

.prog-tiles-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.prog-tile {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 6px 10px;
}

.prog-tile-label {
    font-size: 9.5px;
    text-transform: uppercase;
    color: var(--text-muted);
    font-weight: 700;
    letter-spacing: 0.2px;
}

.prog-tile-val {
    font-size: 13px;
    font-weight: 800;
    color: var(--primary);
    margin-top: 2px;
}

.prog-bar-wrap {
    background: #e0e0e0;
    height: 7px;
    border-radius: 3.5px;
    overflow: hidden;
}

.prog-bar-fill {
    height: 100%;
    background: var(--success);
}

.prog-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    padding-top: 6px;
    border-top: 1px dashed var(--border);
}

.prog-meta {
    color: var(--text-muted);
    line-height: 1.35;
}

/* ========================================== */
/* TAB 4: BUDGETING & RAB MOBILE CARDS        */
/* ========================================== */
.mobile-budget-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    box-shadow: 0 1px 3px rgba(44,24,16,.04);
}

.budget-item-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--primary);
    line-height: 1.35;
    margin: 4px 0;
}

.budget-item-unit {
    font-size: 11.5px;
    color: var(--text-muted);
}

.budget-amount-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
    background: var(--bg);
    padding: 8px 10px;
    border-radius: 6px;
}

.budget-amount-col {
    display: flex;
    flex-direction: column;
}

.b-lbl {
    font-size: 9.5px;
    color: var(--text-muted);
    font-weight: 700;
    text-transform: uppercase;
}

.b-val {
    font-size: 11.5px;
    font-weight: 700;
    margin-top: 2px;
    word-break: break-all;
}

.budget-item-notes {
    font-size: 11px;
    color: var(--accent-dark);
    background: rgba(200,148,26,0.06);
    padding: 6px 8px;
    border-radius: 4px;
}

/* Modals */
.custom-modal {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
}

.modal-backdrop {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(44,24,16,0.6);
    backdrop-filter: blur(4px);
}

.modal-dialog {
    position: relative;
    z-index: 10000;
    background: #fffcf5;
    border: 1px solid var(--border);
    border-radius: 12px;
    width: 100%;
    max-width: 520px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 30px rgba(0,0,0,.3);
    overflow: hidden;
    animation: popIn .2s ease;
}

@keyframes popIn {
    from { opacity: 0; transform: scale(.96); }
    to { opacity: 1; transform: scale(1); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    background: #faf3e0;
}

.modal-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary);
    margin: 0;
}

.modal-body {
    padding: 16px 18px;
    overflow-y: auto;
    flex: 1;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    padding: 12px 18px;
    border-top: 1px solid var(--border);
    background: #faf3e0;
}

.btn-close {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: var(--text-muted);
}

.form-label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 4px;
}

.form-control {
    width: 100%;
    box-sizing: border-box;
    padding: 8px 10px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 12.5px;
    font-family: inherit;
    background: #fff;
}

.form-control:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 2px rgba(200,148,26,.2);
}

.grid-2-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

/* ========================================== */
/* RESPONSIVE MEDIA QUERIES                   */
/* ========================================== */
@media (max-width: 1100px) {
    .haberja-overview-grid {
        grid-template-columns: 1fr !important;
    }
}

@media (max-width: 991px) {
    .haberja-kpi-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
}

@media (max-width: 768px) {
    .hide-mobile-table {
        display: none !important;
    }
    .show-mobile-cards {
        display: block !important;
    }
    .haberja-hero-body {
        padding: 16px;
    }
    .haberja-hero-title {
        font-size: 20px;
    }
    .haberja-watermark {
        font-size: 90px;
        right: -10px;
        bottom: -20px;
    }
    .panitia-cards-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hide-xs {
        display: none !important;
    }
    .haberja-page-header {
        margin-bottom: 14px;
    }
    .page-header-title {
        font-size: 18px !important;
    }
    .haberja-kpi-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .haberja-kpi-card {
        padding: 12px;
    }
    .kpi-value {
        font-size: 15px;
    }
    .kpi-label {
        font-size: 9.5px;
    }
    .haberja-tab-link {
        padding: 8px 12px;
        font-size: 12px;
    }
    .grid-2-col {
        grid-template-columns: 1fr;
        gap: 6px;
    }
}
</style>

<!-- SCRIPT LOGIC -->
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function filterSeksi(slug, btn) {
    // Update active chip
    document.querySelectorAll('.seksi-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');

    // Show/hide groups
    const groups = document.querySelectorAll('.seksi-group-card');
    groups.forEach(g => {
        if (slug === 'all' || g.getAttribute('data-seksi') === slug) {
            g.style.display = 'block';
        } else {
            g.style.display = 'none';
        }
    });
}

function filterDanaStatus(status, btn) {
    document.querySelectorAll('.dana-filter-btn').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');

    // Desktop rows
    const rows = document.querySelectorAll('.dana-table-row');
    rows.forEach(r => {
        if (status === 'all' || r.getAttribute('data-status') === status) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });

    // Mobile cards
    const cards = document.querySelectorAll('.dana-mobile-card');
    cards.forEach(c => {
        if (status === 'all' || c.getAttribute('data-status') === status) {
            c.style.display = 'block';
        } else {
            c.style.display = 'none';
        }
    });
}

function filterBudgetType(type, btn) {
    document.querySelectorAll('.budget-toggle-btn').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');

    const secPengeluaran = document.getElementById('sectionPengeluaran');
    const secPemasukan = document.getElementById('sectionPemasukan');

    if (type === 'all') {
        if (secPengeluaran) secPengeluaran.style.display = 'block';
        if (secPemasukan) secPemasukan.style.display = 'block';
    } else if (type === 'pengeluaran') {
        if (secPengeluaran) secPengeluaran.style.display = 'block';
        if (secPemasukan) secPemasukan.style.display = 'none';
    } else if (type === 'pemasukan') {
        if (secPengeluaran) secPengeluaran.style.display = 'none';
        if (secPemasukan) secPemasukan.style.display = 'block';
    }
}

function editPanitia(data) {
    document.getElementById('panitiaModalTitle').innerText = 'Edit Personil Panitia';
    const form = document.getElementById('formPanitia');
    form.action = '/haberja/panitia/' + data.id;
    document.getElementById('panitiaMethod').value = 'PUT';
    document.getElementById('panitia_event_id').value = data.event_id || '';
    document.getElementById('panitia_seksi').value = data.seksi || 'Badan Pengurus Harian (BPH)';
    document.getElementById('panitia_nama').value = data.nama || '';
    document.getElementById('panitia_jabatan').value = data.jabatan || '';
    document.getElementById('panitia_telepon').value = data.telepon || '';
    document.getElementById('panitia_tugas_pokok').value = data.tugas_pokok || '';
    document.getElementById('panitia_urutan').value = data.urutan || 0;
    openModal('modalTambahPanitia');
}

function editDana(data) {
    document.getElementById('danaModalTitle').innerText = 'Edit Program Pencarian Dana';
    const form = document.getElementById('formDana');
    form.action = '/haberja/dana-plan/' + data.id;
    document.getElementById('danaMethod').value = 'PUT';
    document.getElementById('dana_event_id').value = data.event_id || '';
    document.getElementById('dana_nama_program').value = data.nama_program || '';
    document.getElementById('dana_deskripsi').value = data.deskripsi || '';
    document.getElementById('dana_target_dana').value = data.target_dana || 0;
    document.getElementById('dana_realisasi_dana').value = data.realisasi_dana || 0;
    document.getElementById('dana_tanggal_mulai').value = data.tanggal_mulai ? data.tanggal_mulai.substring(0, 10) : '';
    document.getElementById('dana_tanggal_selesai').value = data.tanggal_selesai ? data.tanggal_selesai.substring(0, 10) : '';
    document.getElementById('dana_penanggung_jawab').value = data.penanggung_jawab || '';
    document.getElementById('dana_status').value = data.status || 'berjalan';
    document.getElementById('dana_catatan').value = data.catatan || '';
    openModal('modalTambahDana');
}

function editBudget(data) {
    document.getElementById('budgetModalTitle').innerText = 'Edit Item Anggaran (RAB)';
    const form = document.getElementById('formBudget');
    form.action = '/haberja/budget/' + data.id;
    document.getElementById('budgetMethod').value = 'PUT';
    document.getElementById('budget_event_id').value = data.event_id || '';
    document.getElementById('budget_tipe').value = data.tipe || 'pengeluaran';
    document.getElementById('budget_seksi').value = data.seksi || '';
    document.getElementById('budget_uraian').value = data.uraian || '';
    document.getElementById('budget_volume').value = data.volume || '';
    document.getElementById('budget_harga_satuan').value = data.harga_satuan || 0;
    document.getElementById('budget_total_anggaran').value = data.total_anggaran || 0;
    document.getElementById('budget_realisasi').value = data.realisasi || 0;
    document.getElementById('budget_keterangan').value = data.keterangan || '';
    openModal('modalTambahBudget');
}
</script>
@endsection
