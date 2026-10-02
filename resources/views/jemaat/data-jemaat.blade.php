@extends('layouts.app')

@section('title', 'Data Jemaat')
@section('header-title', 'Data Jemaat')

@section('styles')
<style>
    .jemaat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
    }
    @media (max-width: 768px) {
        .jemaat-grid {
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 18px;
        }
    }
    @media (max-width: 480px) {
        .jemaat-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
    
    .family-card {
        background: var(--card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
    }
    .family-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }
    .family-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-dark), var(--accent-light), var(--accent-dark));
    }
    
    .family-card-header {
        padding: 18px 20px;
        background: linear-gradient(135deg, rgba(200,148,26,0.06), transparent);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    
    .family-icon {
        font-size: 24px;
        background: #fef5dc;
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(200,148,26,0.25);
        flex-shrink: 0;
    }
    
    .family-name {
        font-family: 'Cinzel', serif;
        font-size: 14.5px;
        font-weight: 700;
        color: var(--primary);
        line-height: 1.3;
    }
    
    .family-meta {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
        font-style: italic;
    }
    
    .family-card-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .family-info {
        font-size: 13px;
        color: var(--text);
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding-bottom: 12px;
        border-bottom: 1px dashed var(--border);
    }
    
    .family-info p {
        line-height: 1.5;
        margin: 0;
    }
    
    .family-members-title {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--accent-dark);
        margin-bottom: 10px;
        font-family: 'Cinzel', serif;
    }
    
    .member-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .member-item {
        padding: 10px 12px;
        background: rgba(245, 237, 224, 0.4);
        border: 1px solid rgba(232, 217, 192, 0.6);
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        transition: all 0.2s ease;
    }
    .member-item:hover {
        background: rgba(200,148,26,0.06);
        border-color: var(--accent-light);
    }
    
    .member-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
    }
    
    .member-name {
        font-size: 13.5px;
        color: var(--text);
        line-height: 1.3;
    }
    
    .member-relation {
        display: flex;
    }
    
    .member-right {
        text-align: right;
        font-size: 11px;
        line-height: 1.4;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 class="page-header-title">Data Jemaat</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Data Jemaat</span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4" style="background: var(--card); border: 1px solid var(--border);">
    <div class="card-body" style="padding: 16px 20px;">
        <form method="GET" action="{{ route('jemaat.data-jemaat') }}" class="d-flex gap-2 align-items-center" style="flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama jemaat, nama keluarga, atau alamat..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Cari</button>
            @if(request('search'))
                <a href="{{ route('jemaat.data-jemaat') }}" class="btn btn-outline" style="border-color: transparent;">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="jemaat-grid">
    @forelse($keluargas as $kel)
        <div class="family-card">
            <div class="family-card-header">
                <div class="family-icon">🏠</div>
                <div>
                    <h3 class="family-name">{{ $kel->nama_keluarga }}</h3>
                    <div class="family-meta">No. KK: {{ $kel->no_kk ?: '-' }}</div>
                </div>
            </div>
            <div class="family-card-body">
                <div class="family-info">
                    <p>📍 <strong>Alamat:</strong> {{ $kel->alamat ?: '-' }}</p>
                    <p>📞 <strong>No. Telp:</strong> {{ $kel->no_telepon ?: '-' }}</p>
                </div>
                
                <div class="family-members-title">Anggota Keluarga</div>
                
                <div class="member-list">
                    @foreach($kel->anggota->sortBy(function($m) {
                        $order = ['Kepala Keluarga' => 1, 'Istri' => 2, 'Anak' => 3];
                        return $order[$m->hubungan_keluarga] ?? 4;
                    }) as $m)
                        <div class="member-item">
                            <div class="member-left">
                                <div class="member-name fw-semibold">
                                    {{ $m->nama_lengkap ?: $m->name }}
                                </div>
                                <div class="member-relation">
                                    @if($m->hubungan_keluarga === 'Kepala Keluarga')
                                        <span class="badge badge-gold" style="font-size: 10px;">{{ $m->hubungan_keluarga }}</span>
                                    @elseif($m->hubungan_keluarga === 'Istri')
                                        <span class="badge badge-info" style="font-size: 10px;">{{ $m->hubungan_keluarga }}</span>
                                    @else
                                        <span class="badge badge-secondary" style="font-size: 10px;">{{ $m->hubungan_keluarga }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="member-right text-muted">
                                <div>{{ $m->jenis_kelamin === 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}</div>
                                <div>
                                    {{ $m->tanggal_lahir ? $m->tanggal_lahir->age . ' Tahun' : '-' }} 
                                    @if($m->tanggal_lahir)
                                        <span style="font-size: 10px;">({{ $m->tanggal_lahir->format('d/m/Y') }})</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="card text-center text-muted" style="grid-column: 1 / -1; padding: 40px; border: 1px dashed var(--border);">
            Tidak menemukan data keluarga jemaat yang sesuai pencarian.
        </div>
    @endforelse
</div>

@if($keluargas->hasPages())
    <div class="pagination-wrapper">
        {{ $keluargas->links() }}
    </div>
@endif
@endsection
