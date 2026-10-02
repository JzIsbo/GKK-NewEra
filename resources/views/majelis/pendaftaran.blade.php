@extends('layouts.app')

@section('title', 'Pendaftaran Jemaat')
@section('header-title', 'Pendaftaran Jemaat')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Manajemen Pendaftaran Jemaat Baru</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pendaftaran Jemaat</span>
    </div>
</div>

<!-- Tabs Status Filter -->
<div class="card mb-2">
    <div class="card-body" style="padding: 12px 24px;">
        <div class="d-flex gap-2" style="flex-wrap: wrap; align-items: center;">
            <span class="text-muted fw-semibold small" style="margin-right: 12px;">Filter Status:</span>
            <a href="{{ route('majelis.pendaftaran.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">Semua</a>
            <a href="{{ route('majelis.pendaftaran.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-primary' : 'btn-outline' }}">Menunggu (Pending)</a>
            <a href="{{ route('majelis.pendaftaran.index', ['status' => 'disetujui']) }}" class="btn btn-sm {{ request('status') === 'disetujui' ? 'btn-primary' : 'btn-outline' }}">Disetujui</a>
            <a href="{{ route('majelis.pendaftaran.index', ['status' => 'ditolak']) }}" class="btn btn-sm {{ request('status') === 'ditolak' ? 'btn-primary' : 'btn-outline' }}">Ditolak</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Daftar Pendaftar</div></div>
    <div class="card-body">
        <div class="table-wrapper table-responsive-stack">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Asal Gereja</th>
                        <th>Tgl Daftar</th>
                        <th>Status</th>
                        <th>Catatan / Keterangan</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $p)
                        <tr>
                            <td data-label="Nama" class="cell-title">
                                <div class="fw-semibold" style="font-size: 14.5px; color: var(--primary);">{{ $p->nama_lengkap }}</div>
                                <div class="text-muted small">Pekerjaan: {{ $p->pekerjaan ?: '-' }}</div>
                            </td>
                            <td data-label="Kontak">
                                <div class="user-contact-info">
                                    <div class="user-email-text">{{ $p->email }}</div>
                                    @if($p->no_telepon)
                                        <div class="text-muted small">{{ $p->no_telepon }}</div>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Asal Gereja">{{ $p->asal_gereja ?: '-' }}</td>
                            <td data-label="Tgl Daftar">{{ $p->created_at->format('d/m/Y') }}</td>
                            <td data-label="Status">
                                @if($p->status === 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($p->status === 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td data-label="Catatan">
                                @if($p->status === 'ditolak')
                                    <span class="text-danger small">{{ $p->catatan_admin ?: '(Tidak ada catatan)' }}</span>
                                @elseif($p->status === 'disetujui')
                                    <span class="text-muted small">Disetujui: {{ $p->approved_at ? $p->approved_at->format('d/m/Y') : '-' }}</span>
                                @else
                                    <span class="text-muted small">Alasan: {{ Str::limit($p->alasan_bergabung, 60) ?: '-' }}</span>
                                @endif
                            </td>
                            <td data-label="Aksi">
                                @if($p->status === 'pending')
                                    <div class="d-flex gap-2">
                                        <!-- Approve Button Form -->
                                        <form method="POST" action="{{ route('majelis.pendaftaran.approve', $p->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">✅ Setujui</button>
                                        </form>

                                        <!-- Reject Action (triggers Javascript inline form) -->
                                        <button type="button" class="btn btn-danger btn-sm" onclick="showRejectForm({{ $p->id }})">❌ Tolak</button>
                                    </div>

                                    <!-- Hidden Reject Input Box -->
                                    <div id="reject-box-{{ $p->id }}" style="display: none; margin-top: 12px; padding: 12px; border: 1px dashed var(--border); border-radius: 8px; background-color: var(--bg-light);">
                                        <form method="POST" action="{{ route('majelis.pendaftaran.reject', $p->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group mb-1">
                                                <label class="form-label small" style="margin-bottom: 4px;">Alasan Penolakan:</label>
                                                <input type="text" name="catatan" class="form-control btn-sm" placeholder="Tulis catatan..." required>
                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-outline btn-sm" onclick="hideRejectForm({{ $p->id }})" style="padding: 3px 8px;">Batal</button>
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px;">Kirim Penolakan</button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada pendaftaran jemaat baru ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $pendaftarans->links() }}
        </div>
    </div>
</div>

<script>
function showRejectForm(id) {
    document.getElementById('reject-box-' + id).style.display = 'block';
}
function hideRejectForm(id) {
    document.getElementById('reject-box-' + id).style.display = 'none';
}
</script>
@endsection
