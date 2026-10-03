@extends('layouts.app')

@section('title', 'Panitia HABERJA (Hari Besar Gereja)')
@section('header-title', 'Panitia HABERJA')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div>
        <h1 class="page-header-title">Panitia Hari-Hari Besar Gereja (HABERJA)</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pelayanan Jemaat</span> &gt; <span>Panitia HABERJA</span>
        </div>
    </div>
    <div class="d-flex gap-2" style="flex-wrap: wrap;">
        <a href="{{ route('haberja.print', ['event' => $selectedKode]) }}" target="_blank" class="btn btn-outline btn-sm">
            🖨️ Cetak / Print RAB &amp; Struktur
        </a>
        @if($canManage)
            @if($activeTab === 'struktur')
                <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modalTambahPanitia')">
                    ➕ Tambah Personil Panitia
                </button>
            @elseif($activeTab === 'dana')
                <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modalTambahDana')">
                    ➕ Tambah Program Dana
                </button>
            @elseif($activeTab === 'budget')
                <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modalTambahBudget')">
                    ➕ Tambah Item RAB
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

<!-- HEADER BANNER & EVENT SELECTOR -->
<div class="card mb-4" style="background: linear-gradient(135deg, rgba(44,24,16,0.95) 0%, rgba(107,26,46,0.92) 100%); color: #fff; border: 1px solid var(--accent); position: relative; overflow: hidden;">
    <div style="position: absolute; right: -20px; bottom: -30px; font-size: 140px; color: rgba(200,148,26,0.06); font-family: 'Cinzel', serif; pointer-events: none;">✝</div>
    <div class="card-body" style="padding: 22px 26px;">
        <div class="d-flex justify-content-between align-items-start" style="flex-wrap: wrap; gap: 16px;">
            <div style="max-width: 680px;">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-gold" style="font-size: 10.5px; letter-spacing: 0.5px; text-transform: uppercase;">HABERJA 2026</span>
                    @if($currentEvent)
                        <span class="badge badge-info" style="font-size: 10.5px;">{{ $currentEvent->nama }}</span>
                    @else
                        <span class="badge badge-info" style="font-size: 10.5px;">Konsolidasi Seluruh Acara</span>
                    @endif
                </div>
                <h2 style="font-family: 'EB Garamond', Georgia, serif; font-size: 26px; color: var(--accent-light); margin-bottom: 6px; font-weight: 600;">
                    @if($currentEvent)
                        {{ $currentEvent->nama }}
                    @else
                        Badan Kepanitiaan Hari-Hari Besar Gereja GEMINDO Kawan Kasih
                    @endif
                </h2>
                <p style="font-size: 13px; color: #e8d9c0; line-height: 1.5; margin-bottom: 10px;">
                    @if($currentEvent)
                        <em>"{{ $currentEvent->tema }}"</em> &mdash; <strong>{{ $currentEvent->ayat_tema }}</strong>
                        <br><span style="font-size: 12px; opacity: 0.9;">{{ $currentEvent->deskripsi }}</span>
                    @else
                        Mengkoordinir persiapan dan perayaan 3 Hari Besar Utama: <strong>Paskah</strong>, <strong>HUT Ke-28 Gereja GEMINDO Kawan Kasih</strong>, serta <strong>Natal &amp; Tahun Baru</strong> secara terpadu, transparan, dan bertanggung jawab.
                    @endif
                </p>
                <div class="d-flex gap-3 align-items-center" style="font-size: 12px; color: #fdf6e3; flex-wrap: wrap;">
                    <div>📅 <strong>Periode:</strong> {{ $currentEvent ? ($currentEvent->tanggal_mulai ? $currentEvent->tanggal_mulai->format('d M Y') . ' s/d ' . ($currentEvent->tanggal_selesai ? $currentEvent->tanggal_selesai->format('d M Y') : '-') : 'Tahun 2026') : 'Tahun Pelayanan 2026 / 2027' }}</div>
                    <div>👥 <strong>Panitia Terdaftar:</strong> {{ $panitias->count() }} Personil</div>
                    <div>💰 <strong>Target RAB:</strong> Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Event Selector Filter -->
            <div style="background: rgba(255,255,255,0.08); padding: 12px 16px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.15); min-width: 240px;">
                <label style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--accent-light); font-weight: 600; display: block; margin-bottom: 6px;">Pilih Acara Hari Besar:</label>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('haberja.index', ['event' => 'semua', 'tab' => $activeTab]) }}" 
                       class="btn btn-sm {{ $selectedKode === 'semua' ? 'btn-primary' : 'btn-outline' }}" 
                       style="justify-content: flex-start; text-align: left; font-size: 12px; padding: 6px 12px;">
                        ✨ Semua Acara (Konsolidasi)
                    </a>
                    @foreach($events as $ev)
                        <a href="{{ route('haberja.index', ['event' => $ev->kode, 'tab' => $activeTab]) }}" 
                           class="btn btn-sm {{ $selectedKode === $ev->kode ? 'btn-primary' : 'btn-outline' }}" 
                           style="justify-content: flex-start; text-align: left; font-size: 12px; padding: 6px 12px;">
                            @if($ev->kode === 'paskah') 🕊️ @elseif($ev->kode === 'hut') 🎂 @else 🎄 @endif {{ $ev->nama }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NAVIGATION TABS -->
<div class="d-flex gap-2 mb-4" style="border-bottom: 2px solid var(--border); padding-bottom: 2px; flex-wrap: wrap;">
    <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'overview']) }}" 
       class="nav-tab {{ $activeTab === 'overview' ? 'active' : '' }}" 
       style="padding: 10px 18px; font-weight: 600; font-size: 13.5px; border-radius: 8px 8px 0 0; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; {{ $activeTab === 'overview' ? 'background: var(--card); border: 1px solid var(--border); border-bottom: 2px solid var(--accent); color: var(--primary);' : 'color: var(--text-muted);' }}">
        📊 Ringkasan &amp; Agenda
    </a>
    <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'struktur']) }}" 
       class="nav-tab {{ $activeTab === 'struktur' ? 'active' : '' }}" 
       style="padding: 10px 18px; font-weight: 600; font-size: 13.5px; border-radius: 8px 8px 0 0; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; {{ $activeTab === 'struktur' ? 'background: var(--card); border: 1px solid var(--border); border-bottom: 2px solid var(--accent); color: var(--primary);' : 'color: var(--text-muted);' }}">
        👥 Struktur Panitia HABERJA
        <span class="badge badge-secondary" style="font-size: 11px;">{{ $panitias->count() }}</span>
    </a>
    <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'dana']) }}" 
       class="nav-tab {{ $activeTab === 'dana' ? 'active' : '' }}" 
       style="padding: 10px 18px; font-weight: 600; font-size: 13.5px; border-radius: 8px 8px 0 0; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; {{ $activeTab === 'dana' ? 'background: var(--card); border: 1px solid var(--border); border-bottom: 2px solid var(--accent); color: var(--primary);' : 'color: var(--text-muted);' }}">
        💰 Planning Pencarian Dana
        <span class="badge badge-gold" style="font-size: 11px;">{{ $persenDana }}%</span>
    </a>
    <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'budget']) }}" 
       class="nav-tab {{ $activeTab === 'budget' ? 'active' : '' }}" 
       style="padding: 10px 18px; font-weight: 600; font-size: 13.5px; border-radius: 8px 8px 0 0; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; {{ $activeTab === 'budget' ? 'background: var(--card); border: 1px solid var(--border); border-bottom: 2px solid var(--accent); color: var(--primary);' : 'color: var(--text-muted);' }}">
        📋 Budgeting &amp; RAB
        <span class="badge badge-info" style="font-size: 11px;">{{ $pengeluarans->count() }} Pos</span>
    </a>
</div>

<!-- ========================================== -->
<!-- TAB 1: OVERVIEW & AGENDA ACARA             -->
<!-- ========================================== -->
@if($activeTab === 'overview')
    <!-- KPI STATS CARDS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 18px; border-left: 4px solid var(--accent);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Kebutuhan Anggaran (RAB)</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--primary); margin: 6px 0;">
                Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">
                Total kebutuhan dana untuk {{ $currentEvent ? $currentEvent->nama : 'seluruh perayaan HABERJA' }}
            </div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--success);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Dana Usaha &amp; Donasi Masuk</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--success); margin: 6px 0;">
                Rp {{ number_format($totalRealisasiDana, 0, ',', '.') }}
            </div>
            <div class="d-flex align-items-center gap-2">
                <div style="flex: 1; background: #e0e0e0; height: 6px; border-radius: 3px; overflow: hidden;">
                    <div style="width: {{ $persenDana }}%; background: var(--success); height: 100%;"></div>
                </div>
                <span style="font-size: 11px; font-weight: 700; color: var(--success);">{{ $persenDana }}%</span>
            </div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--burgundy);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Realisasi Pengeluaran</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--burgundy); margin: 6px 0;">
                Rp {{ number_format($totalRealisasiPengeluaran, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">
                Belanja dan operasional yang telah dikeluarkan
            </div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--warning);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Sisa Target Usaha Dana</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--warning); margin: 6px 0;">
                Rp {{ number_format($sisaTargetDana, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">
                Kekurangan target yang sedang dipacu seksi dana
            </div>
        </div>
    </div>

    <!-- 3 ACARA HARI BESAR SHOWCASE -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">Agenda 3 Acara Hari Besar Gereja GEMINDO (HABERJA 2026)</div>
            <span class="badge badge-gold">Kalender Gerejawi 2026</span>
        </div>
        <div class="card-body" style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 18px;">
                @foreach($events as $ev)
                    <div style="background: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 6px rgba(44,24,16,.04); transition: transform .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div style="font-size: 28px;">
                                    @if($ev->kode === 'paskah') 🕊️ @elseif($ev->kode === 'hut') 🎂 @else 🎄 @endif
                                </div>
                                <span class="badge {{ $ev->kode === 'paskah' ? 'badge-success' : ($ev->kode === 'hut' ? 'badge-gold' : 'badge-danger') }}">
                                    {{ strtoupper($ev->kode) }} 2026
                                </span>
                            </div>
                            <h3 style="font-size: 17px; font-weight: 700; color: var(--primary); margin-bottom: 4px;">{{ $ev->nama }}</h3>
                            <div style="font-size: 12px; color: var(--burgundy); font-weight: 600; margin-bottom: 8px;">
                                📖 {{ $ev->ayat_tema }}: "{{ $ev->tema }}"
                            </div>
                            <p style="font-size: 12.5px; color: var(--text-muted); line-height: 1.45; margin-bottom: 14px;">
                                {{ $ev->deskripsi }}
                            </p>
                        </div>
                        <div style="border-top: 1px dashed var(--border); padding-top: 12px;">
                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 12px;">
                                <span class="text-muted">Target Anggaran:</span>
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

    <!-- QUICK OVERVIEW: DANA & STRUKTUR SNAPSHOT -->
    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 20px; align-items: start;" class="overview-grid">
        <!-- Snapshot Usaha Dana -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Progress Program Pencarian Dana</div>
                <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'dana']) }}" class="small" style="color: var(--accent-dark); font-weight: 600; text-decoration: none;">
                    Selengkapnya &rarr;
                </a>
            </div>
            <div class="card-body" style="padding: 16px;">
                <div class="d-flex flex-column gap-3">
                    @forelse($danaPlans->take(4) as $dp)
                        <div style="padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff;">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div style="font-weight: 600; font-size: 13.5px; color: var(--primary);">{{ $dp->nama_program }}</div>
                                <span class="badge {{ $dp->status === 'tercapai' || $dp->status === 'selesai' ? 'badge-success' : 'badge-gold' }}" style="font-size: 10px;">
                                    {{ ucfirst($dp->status) }}
                                </span>
                            </div>
                            <div class="text-muted small mb-2" style="font-size: 11.5px;">PIC: {{ $dp->penanggung_jawab }}</div>
                            <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                                <span>Realisasi: <strong>Rp {{ number_format($dp->realisasi_dana, 0, ',', '.') }}</strong></span>
                                <span class="text-muted">Target: Rp {{ number_format($dp->target_dana, 0, ',', '.') }}</span>
                            </div>
                            <div style="background: #e9ecef; height: 6px; border-radius: 3px; overflow: hidden;">
                                <div style="width: {{ $dp->persentase }}%; background: var(--success); height: 100%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted text-center py-4">Belum ada program pencarian dana tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Snapshot BPH Panitia -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Inti Kepengurusan (BPH) HABERJA</div>
                <a href="{{ route('haberja.index', ['event' => $selectedKode, 'tab' => 'struktur']) }}" class="small" style="color: var(--accent-dark); font-weight: 600; text-decoration: none;">
                    Semua Seksi &rarr;
                </a>
            </div>
            <div class="card-body" style="padding: 16px;">
                <div class="d-flex flex-column gap-2">
                    @forelse($panitias->where('seksi', 'Badan Pengurus Harian (BPH)')->take(5) as $p)
                        <div class="d-flex align-items-center gap-3 p-2" style="border-radius: 8px; border: 1px solid var(--border); background: #fff;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--primary); color: var(--accent-light); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: 13px; color: var(--primary);">{{ $p->nama }}</div>
                                <div style="font-size: 11.5px; color: var(--accent-dark); font-weight: 600;">{{ $p->jabatan }}</div>
                            </div>
                            @if($p->telepon)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->telepon) }}" target="_blank" class="btn btn-outline btn-sm" style="font-size: 11px; padding: 4px 8px;" title="Chat WhatsApp">
                                    💬 WA
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
    <div class="card mb-4" style="background: linear-gradient(135deg, rgba(200,148,26,.08), rgba(44,24,16,.03)); border: 1px dashed var(--accent);">
        <div class="card-body" style="padding: 14px 18px;">
            <div class="d-flex align-items-center gap-3">
                <div style="font-size: 26px;">🏛️</div>
                <div>
                    <div class="fw-bold" style="color: var(--primary); font-size: 13.5px;">Bagan &amp; Susunan Struktur Panitia HABERJA 2026</div>
                    <div class="text-muted small" style="font-size: 12px;">
                        Kepanitiaan ditetapkan berdasarkan Surat Keputusan Majelis Jemaat GEMINDO Kawan Kasih untuk melayani seluruh rangkaian perayaan hari besar gereja (Paskah, HUT Gereja, Natal &amp; Tahun Baru).
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTIONS LOOP -->
    @foreach($panitiaBySeksi as $seksiName => $members)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #fdf6e3 0%, #fff 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size: 18px;">
                        @if(str_contains(strtolower($seksiName), 'penasihat')) 🕊️
                        @elseif(str_contains(strtolower($seksiName), 'bph') || str_contains(strtolower($seksiName), 'harian')) 👑
                        @elseif(str_contains(strtolower($seksiName), 'acara')) 📖
                        @elseif(str_contains(strtolower($seksiName), 'dana')) 💰
                        @elseif(str_contains(strtolower($seksiName), 'perlengkapan') || str_contains(strtolower($seksiName), 'dekorasi')) 🎪
                        @elseif(str_contains(strtolower($seksiName), 'konsumsi')) 🍱
                        @elseif(str_contains(strtolower($seksiName), 'publikasi') || str_contains(strtolower($seksiName), 'multimedia')) 📡
                        @elseif(str_contains(strtolower($seksiName), 'keamanan')) 🛡️
                        @else ❤️ @endif
                    </span>
                    <div class="card-title" style="font-size: 15px;">{{ $seksiName }}</div>
                </div>
                <span class="badge badge-secondary">{{ $members->count() }} Personil</span>
            </div>
            <div class="card-body" style="padding: 18px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                    @foreach($members as $m)
                        <div style="background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                            <div>
                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, var(--primary) 0%, #4a2818 100%); color: var(--accent-light); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 17px; flex-shrink: 0; box-shadow: 0 2px 5px rgba(0,0,0,.15);">
                                        {{ strtoupper(substr($m->nama, 0, 1)) }}
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; font-size: 14px; color: var(--primary); line-height: 1.3;">{{ $m->nama }}</div>
                                        <div style="font-size: 12px; color: var(--accent-dark); font-weight: 600; margin-top: 2px;">{{ $m->jabatan }}</div>
                                        @if($m->event)
                                            <span class="badge badge-info" style="font-size: 9px; margin-top: 4px;">{{ $m->event->nama }}</span>
                                        @endif
                                    </div>
                                </div>

                                @if($m->tugas_pokok)
                                    <div style="font-size: 11.5px; color: var(--text-muted); background: var(--bg); padding: 8px 10px; border-radius: 6px; line-height: 1.45; margin-bottom: 10px;">
                                        <strong>Tugas Pokok:</strong> {{ $m->tugas_pokok }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2" style="border-top: 1px solid #f0e6d6; font-size: 11.5px;">
                                <div>
                                    @if($m->telepon)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $m->telepon) }}" target="_blank" style="color: var(--success); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                            📞 {{ $m->telepon }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                @if($canManage)
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="editPanitia({{ json_encode($m) }})">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('haberja.panitia.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus anggota panitia {{ $m->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px; color: var(--danger); border-color: rgba(139,26,26,.3);">
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
    <!-- FINANCIAL FUNDRAISING SUMMARY -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 18px; border-left: 4px solid var(--primary);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Target Usaha Dana</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--primary); margin: 6px 0;">
                Rp {{ number_format($totalTargetDana, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">Akumulasi target seluruh program dana</div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--success);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Realisasi Masuk</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--success); margin: 6px 0;">
                Rp {{ number_format($totalRealisasiDana, 0, ',', '.') }}
            </div>
            <div class="small text-success" style="font-size: 11.5px; font-weight: 600;">{{ $persenDana }}% dari total target tercapai</div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--warning);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Sisa Target Dana</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--warning); margin: 6px 0;">
                Rp {{ number_format($sisaTargetDana, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">Dikejar melalui aksi &amp; sponsor lanjutan</div>
        </div>
    </div>

    <!-- PROGRAM DANA LIST -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">Daftar Rencana &amp; Realisasi Aksi Usaha Dana HABERJA</div>
            <span class="badge badge-gold">{{ $danaPlans->count() }} Program</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Program &amp; Strategi Usaha Dana</th>
                            <th>Target Dana</th>
                            <th>Realisasi Terkumpul</th>
                            <th style="width: 140px;">Capaian (%)</th>
                            <th>Jadwal Pelaksanaan</th>
                            <th>Penanggung Jawab (PIC)</th>
                            <th>Status</th>
                            @if($canManage)
                                <th style="width: 120px; text-align: center;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($danaPlans as $dp)
                            <tr>
                                <td data-label="Program">
                                    <div style="font-weight: 700; font-size: 13.5px; color: var(--primary);">{{ $dp->nama_program }}</div>
                                    @if($dp->event)
                                        <span class="badge badge-info" style="font-size: 9.5px; margin: 3px 0;">{{ $dp->event->nama }}</span>
                                    @endif
                                    <div class="text-muted small" style="font-size: 11.5px; line-height: 1.4; margin-top: 3px;">
                                        {{ $dp->deskripsi }}
                                    </div>
                                    @if($dp->catatan)
                                        <div style="font-size: 11px; color: var(--accent-dark); font-style: italic; margin-top: 4px;">
                                            💡 Catatan: {{ $dp->catatan }}
                                        </div>
                                    @endif
                                </td>
                                <td data-label="Target" style="white-space: nowrap; font-weight: 600;">
                                    Rp {{ number_format($dp->target_dana, 0, ',', '.') }}
                                </td>
                                <td data-label="Realisasi" style="white-space: nowrap; font-weight: 700; color: var(--success);">
                                    Rp {{ number_format($dp->realisasi_dana, 0, ',', '.') }}
                                </td>
                                <td data-label="Capaian">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex: 1; background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden; min-width: 60px;">
                                            <div style="width: {{ $dp->persentase }}%; background: {{ $dp->persentase >= 100 ? 'var(--success)' : 'var(--accent)' }}; height: 100%;"></div>
                                        </div>
                                        <span style="font-size: 11.5px; font-weight: 700; color: {{ $dp->persentase >= 100 ? 'var(--success)' : 'var(--primary)' }};">
                                            {{ $dp->persentase }}%
                                        </span>
                                    </div>
                                </td>
                                <td data-label="Jadwal" style="font-size: 12px; white-space: nowrap;">
                                    {{ $dp->tanggal_mulai ? $dp->tanggal_mulai->format('d/m/Y') : '-' }} 
                                    @if($dp->tanggal_selesai) s/d {{ $dp->tanggal_selesai->format('d/m/Y') }} @endif
                                </td>
                                <td data-label="PIC" style="font-size: 12.5px; font-weight: 500;">
                                    {{ $dp->penanggung_jawab }}
                                </td>
                                <td data-label="Status">
                                    @if($dp->status === 'selesai' || $dp->status === 'tercapai')
                                        <span class="badge badge-success">{{ ucfirst($dp->status) }}</span>
                                    @elseif($dp->status === 'berjalan')
                                        <span class="badge badge-gold">Sedang Berjalan</span>
                                    @else
                                        <span class="badge badge-secondary">Rencana</span>
                                    @endif
                                </td>
                                @if($canManage)
                                    <td data-label="Aksi" style="text-align: center; white-space: nowrap;">
                                        <button type="button" class="btn btn-outline btn-sm" style="padding: 3px 8px; font-size: 11px;" onclick="editDana({{ json_encode($dp) }})">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('haberja.dana.destroy', $dp->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus program {{ $dp->nama_program }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm" style="padding: 3px 8px; font-size: 11px; color: var(--danger); border-color: rgba(139,26,26,.3);">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $canManage ? 8 : 7 }}" class="text-center py-4 text-muted">
                                    Belum ada perencanaan pencarian dana.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- ========================================== -->
<!-- TAB 4: BUDGETING & RAB                     -->
<!-- ========================================== -->
@if($activeTab === 'budget')
    <!-- REKAPITULASI KEUANGAN RAB -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 18px; border-left: 4px solid var(--burgundy);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Kebutuhan Biaya (Pengeluaran)</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--burgundy); margin: 6px 0;">
                Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">Realisasi belanja: <strong>Rp {{ number_format($totalRealisasiPengeluaran, 0, ',', '.') }}</strong></div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--success);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Estimasi Pemasukan</div>
            <div style="font-size: 22px; font-weight: 700; color: var(--success); margin: 6px 0;">
                Rp {{ number_format($totalRencanaPemasukan, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">Realisasi masuk: <strong>Rp {{ number_format($totalRealisasiPemasukan, 0, ',', '.') }}</strong></div>
        </div>

        <div class="card" style="padding: 18px; border-left: 4px solid var(--accent);">
            <div class="text-muted small" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Keseimbangan Anggaran (RAB)</div>
            @php $selisihRAB = $totalRencanaPemasukan - $totalTargetRAB; @endphp
            <div style="font-size: 22px; font-weight: 700; color: {{ $selisihRAB >= 0 ? 'var(--success)' : 'var(--danger)' }}; margin: 6px 0;">
                {{ $selisihRAB >= 0 ? '+' : '' }} Rp {{ number_format($selisihRAB, 0, ',', '.') }}
            </div>
            <div class="small text-muted" style="font-size: 11.5px;">{{ $selisihRAB >= 0 ? 'Anggaran berimbang / surplus' : 'Perlu dipacu dari donatur & usaha dana' }}</div>
        </div>
    </div>

    <!-- 1. TABEL RENCANA PENGELUARAN -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #faf0f0 0%, #fff 100%);">
            <div class="d-flex align-items-center gap-2">
                <span style="font-size: 18px;">📉</span>
                <div class="card-title" style="color: var(--burgundy);">Rencana Anggaran Biaya (RAB) Pengeluaran</div>
            </div>
            <span class="badge badge-danger">{{ $pengeluarans->count() }} Item Belanja</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Pos Seksi / Alokasi</th>
                            <th>Uraian Kebutuhan Belanja</th>
                            <th>Volume</th>
                            <th>Harga Satuan</th>
                            <th>Total Anggaran</th>
                            <th>Realisasi Belanja</th>
                            <th>Selisih (Sisa)</th>
                            <th>Keterangan</th>
                            @if($canManage)
                                <th style="width: 110px; text-align: center;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengeluarans as $bg)
                            <tr>
                                <td data-label="Seksi" style="font-weight: 600; font-size: 12.5px; color: var(--primary);">
                                    {{ $bg->seksi }}
                                    @if($bg->event)
                                        <div style="font-size: 10px; color: var(--accent-dark);">{{ $bg->event->nama }}</div>
                                    @endif
                                </td>
                                <td data-label="Uraian" style="font-weight: 600; font-size: 13px;">
                                    {{ $bg->uraian }}
                                </td>
                                <td data-label="Volume" style="font-size: 12px; white-space: nowrap;">
                                    {{ $bg->volume ?? '-' }}
                                </td>
                                <td data-label="Satuan" style="font-size: 12px; white-space: nowrap;">
                                    Rp {{ number_format($bg->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td data-label="Total" style="font-weight: 700; white-space: nowrap; color: var(--primary);">
                                    Rp {{ number_format($bg->total_anggaran, 0, ',', '.') }}
                                </td>
                                <td data-label="Realisasi" style="font-weight: 600; white-space: nowrap; color: var(--burgundy);">
                                    Rp {{ number_format($bg->realisasi, 0, ',', '.') }}
                                </td>
                                <td data-label="Selisih" style="font-weight: 600; white-space: nowrap; color: {{ $bg->selisih >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                                    Rp {{ number_format($bg->selisih, 0, ',', '.') }}
                                </td>
                                <td data-label="Keterangan" style="font-size: 11.5px; color: var(--text-muted);">
                                    {{ $bg->keterangan ?? '-' }}
                                </td>
                                @if($canManage)
                                    <td data-label="Aksi" style="text-align: center; white-space: nowrap;">
                                        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="editBudget({{ json_encode($bg) }})">
                                            ✏️
                                        </button>
                                        <form action="{{ route('haberja.budget.destroy', $bg->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus item belanja {{ $bg->uraian }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px; color: var(--danger); border-color: rgba(139,26,26,.3);">
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
                            <td style="color: var(--primary);">Rp {{ number_format($totalTargetRAB, 0, ',', '.') }}</td>
                            <td style="color: var(--burgundy);">Rp {{ number_format($totalRealisasiPengeluaran, 0, ',', '.') }}</td>
                            <td style="color: var(--success);">Rp {{ number_format($totalTargetRAB - $totalRealisasiPengeluaran, 0, ',', '.') }}</td>
                            <td colspan="{{ $canManage ? 2 : 1 }}"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. TABEL RENCANA PEMASUKAN -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #eef9f2 0%, #fff 100%);">
            <div class="d-flex align-items-center gap-2">
                <span style="font-size: 18px;">📈</span>
                <div class="card-title" style="color: var(--success);">Rencana Sumber Pemasukan / Penerimaan Dana</div>
            </div>
            <span class="badge badge-success">{{ $pemasukans->count() }} Sumber Dana</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Kategori Sumber</th>
                            <th>Uraian Sumber Dana</th>
                            <th>Target Penerimaan</th>
                            <th>Realisasi Masuk</th>
                            <th>Sisa Target</th>
                            <th>Keterangan</th>
                            @if($canManage)
                                <th style="width: 110px; text-align: center;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemasukans as $pm)
                            <tr>
                                <td data-label="Kategori" style="font-weight: 600; font-size: 12.5px; color: var(--primary);">
                                    {{ $pm->seksi }}
                                    @if($pm->event)
                                        <div style="font-size: 10px; color: var(--accent-dark);">{{ $pm->event->nama }}</div>
                                    @endif
                                </td>
                                <td data-label="Uraian" style="font-weight: 600; font-size: 13px;">
                                    {{ $pm->uraian }}
                                </td>
                                <td data-label="Target" style="font-weight: 700; white-space: nowrap; color: var(--primary);">
                                    Rp {{ number_format($pm->total_anggaran, 0, ',', '.') }}
                                </td>
                                <td data-label="Realisasi" style="font-weight: 700; white-space: nowrap; color: var(--success);">
                                    Rp {{ number_format($pm->realisasi, 0, ',', '.') }}
                                </td>
                                <td data-label="Sisa" style="font-weight: 600; white-space: nowrap; color: {{ $pm->selisih > 0 ? 'var(--warning)' : 'var(--success)' }};">
                                    Rp {{ number_format(max(0, $pm->total_anggaran - $pm->realisasi), 0, ',', '.') }}
                                </td>
                                <td data-label="Keterangan" style="font-size: 11.5px; color: var(--text-muted);">
                                    {{ $pm->keterangan ?? '-' }}
                                </td>
                                @if($canManage)
                                    <td data-label="Aksi" style="text-align: center; white-space: nowrap;">
                                        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="editBudget({{ json_encode($pm) }})">
                                            ✏️
                                        </button>
                                        <form action="{{ route('haberja.budget.destroy', $pm->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus item penerimaan {{ $pm->uraian }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px; color: var(--danger); border-color: rgba(139,26,26,.3);">
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
                            <td style="color: var(--primary);">Rp {{ number_format($totalRencanaPemasukan, 0, ',', '.') }}</td>
                            <td style="color: var(--success);">Rp {{ number_format($totalRealisasiPemasukan, 0, ',', '.') }}</td>
                            <td style="color: var(--warning);">Rp {{ number_format(max(0, $totalRencanaPemasukan - $totalRealisasiPemasukan), 0, ',', '.') }}</td>
                            <td colspan="{{ $canManage ? 2 : 1 }}"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif

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
                    <h3 id="panitiaModalTitle" style="font-size: 17px; font-weight: 700; color: var(--primary);">Tambah Anggota Panitia HABERJA</h3>
                    <button type="button" class="btn-close" onclick="closeModal('modalTambahPanitia')">✕</button>
                </div>
                <div class="modal-body" style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label class="form-label">Terkait Acara:</label>
                        <select name="event_id" id="panitia_event_id" class="form-control">
                            <option value="">-- Panitia Induk / Semua Acara --</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
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
                    <div>
                        <label class="form-label">Nama Lengkap &amp; Gelar: *</label>
                        <input type="text" name="nama" id="panitia_nama" class="form-control" required placeholder="Contoh: Daniel Sihombing, S.T.">
                    </div>
                    <div>
                        <label class="form-label">Jabatan dalam Panitia: *</label>
                        <input type="text" name="jabatan" id="panitia_jabatan" class="form-control" required placeholder="Contoh: Koordinator Seksi Acara">
                    </div>
                    <div>
                        <label class="form-label">Nomor WhatsApp / Telepon:</label>
                        <input type="text" name="telepon" id="panitia_telepon" class="form-control" placeholder="0812-xxxx-xxxx">
                    </div>
                    <div>
                        <label class="form-label">Tugas Pokok &amp; Tanggung Jawab:</label>
                        <textarea name="tugas_pokok" id="panitia_tugas_pokok" rows="3" class="form-control" placeholder="Rincian tugas dan fungsi koordinasi..."></textarea>
                    </div>
                    <div>
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
                    <h3 id="danaModalTitle" style="font-size: 17px; font-weight: 700; color: var(--primary);">Tambah Program Usaha Dana</h3>
                    <button type="button" class="btn-close" onclick="closeModal('modalTambahDana')">✕</button>
                </div>
                <div class="modal-body" style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label class="form-label">Terkait Acara:</label>
                        <select name="event_id" id="dana_event_id" class="form-control">
                            <option value="">-- Umum / Semua Acara --</option>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Nama Program Aksi Dana: *</label>
                        <input type="text" name="nama_program" id="dana_nama_program" class="form-control" required placeholder="Contoh: Aksi Bazaar Makanan Tradisional">
                    </div>
                    <div>
                        <label class="form-label">Strategi / Deskripsi Program:</label>
                        <textarea name="deskripsi" id="dana_deskripsi" rows="2" class="form-control" placeholder="Penjelasan teknis pengumpulan dana..."></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label class="form-label">Target Dana (Rp): *</label>
                            <input type="number" name="target_dana" id="dana_target_dana" class="form-control" required min="0" placeholder="10000000">
                        </div>
                        <div>
                            <label class="form-label">Realisasi Masuk (Rp):</label>
                            <input type="number" name="realisasi_dana" id="dana_realisasi_dana" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label class="form-label">Tanggal Mulai:</label>
                            <input type="date" name="tanggal_mulai" id="dana_tanggal_mulai" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Tanggal Selesai:</label>
                            <input type="date" name="tanggal_selesai" id="dana_tanggal_selesai" class="form-control">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Penanggung Jawab (PIC):</label>
                        <input type="text" name="penanggung_jawab" id="dana_penanggung_jawab" class="form-control" placeholder="Nama koordinator seksi dana">
                    </div>
                    <div>
                        <label class="form-label">Status Program: *</label>
                        <select name="status" id="dana_status" class="form-control" required>
                            <option value="rencana">Rencana</option>
                            <option value="berjalan" selected>Sedang Berjalan</option>
                            <option value="tercapai">Target Tercapai</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div>
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
                    <h3 id="budgetModalTitle" style="font-size: 17px; font-weight: 700; color: var(--primary);">Tambah Item Anggaran (RAB)</h3>
                    <button type="button" class="btn-close" onclick="closeModal('modalTambahBudget')">✕</button>
                </div>
                <div class="modal-body" style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label class="form-label">Acara Hari Besar: *</label>
                        <select name="event_id" id="budget_event_id" class="form-control" required>
                            @foreach($events as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label class="form-label">Tipe Item: *</label>
                            <select name="tipe" id="budget_tipe" class="form-control" required>
                                <option value="pengeluaran">Pengeluaran (Belanja)</option>
                                <option value="pemasukan">Pemasukan (Sumber Dana)</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Pos Seksi / Alokasi: *</label>
                            <input type="text" name="seksi" id="budget_seksi" class="form-control" required placeholder="Contoh: Seksi Acara & Ibadah">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Uraian Kebutuhan / Sumber Dana: *</label>
                        <input type="text" name="uraian" id="budget_uraian" class="form-control" required placeholder="Contoh: Konsumsi Ibadah Paskah Subuh">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label class="form-label">Volume (Jumlah/Satuan):</label>
                            <input type="text" name="volume" id="budget_volume" class="form-control" placeholder="Contoh: 350 porsi">
                        </div>
                        <div>
                            <label class="form-label">Harga Satuan (Rp):</label>
                            <input type="number" name="harga_satuan" id="budget_harga_satuan" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <label class="form-label">Total Anggaran (Rp): *</label>
                            <input type="number" name="total_anggaran" id="budget_total_anggaran" class="form-control" required min="0" placeholder="5000000">
                        </div>
                        <div>
                            <label class="form-label">Realisasi (Rp):</label>
                            <input type="number" name="realisasi" id="budget_realisasi" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Keterangan / Rincian Tambahan:</label>
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

<style>
/* CSS MODAL & OVERLAY */
.custom-modal {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    z-index: 9999; display: flex; align-items: center; justify-content: center;
    padding: 16px;
}
.modal-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(44,24,16,0.55); backdrop-filter: blur(3px);
}
.modal-dialog {
    position: relative; z-index: 10000; background: #fffcf5;
    border: 1px solid var(--border); border-radius: 12px;
    width: 100%; max-width: 540px; box-shadow: 0 10px 30px rgba(0,0,0,.25);
    overflow: hidden; animation: popIn .2s ease;
}
@keyframes popIn {
    from { opacity: 0; transform: scale(.95); }
    to { opacity: 1; transform: scale(1); }
}
.modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 20px; border-bottom: 1px solid var(--border);
    background: #faf3e0;
}
.modal-body {
    padding: 20px; max-height: 75vh; overflow-y: auto;
}
.modal-footer {
    display: flex; justify-content: flex-end; gap: 8px;
    padding: 14px 20px; border-top: 1px solid var(--border);
    background: #faf3e0;
}
.btn-close {
    background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-muted);
}
.form-label {
    display: block; font-size: 12px; font-weight: 600; color: var(--primary); margin-bottom: 4px;
}
.form-control {
    width: 100%; padding: 8px 12px; border: 1px solid var(--border);
    border-radius: 6px; font-size: 13px; font-family: inherit; background: #fff;
}
.form-control:focus {
    outline: none; border-color: var(--accent); box-shadow: 0 0 0 2px rgba(200,148,26,.2);
}
@media (max-width: 900px) {
    .overview-grid { grid-template-columns: 1fr !important; }
}
</style>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function editPanitia(data) {
    document.getElementById('panitiaModalTitle').innerText = 'Edit Anggota Panitia';
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
