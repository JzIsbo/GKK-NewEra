@extends('layouts.app')

@section('title', 'Persetujuan Pendaftaran')
@section('header-title', 'Approval Pendaftaran')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">Approval Pendaftaran Jemaat Baru (Administrasi)</h1>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Beranda</a> &gt; <span>Pendaftaran Jemaat</span>
    </div>
</div>

<div class="card">
    <div class="card-header"><div class="card-title">Berkas Pendaftaran</div></div>
    <div class="card-body">
        <div class="table-wrapper">
            <table class="table-responsive-stack">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Kontak</th>
                        <th>Asal Gereja</th>
                        <th>Tgl Daftar</th>
                        <th>Status</th>
                        <th>Catatan Penolakan</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $p)
                        <tr>
                            <td data-label="Nama Lengkap" class="cell-title">
                                <div class="fw-semibold" style="font-size: 15px;">{{ $p->nama_lengkap }}</div>
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
                            <td data-label="Asal Gereja">{{ $p->asal_regex ?: ($p->asal_gereja ?: '-') }}</td>
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
                            <td data-label="Catatan Penolakan">
                                <span class="text-danger small">{{ $p->catatan_admin ?: '-' }}</span>
                            </td>
                            <td data-label="Aksi">
                                @if($p->status === 'pending')
                                    <div class="table-actions">
                                        <!-- Approve Form -->
                                        <form method="POST" action="{{ route('admin.pendaftaran.approve', $p->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini? User baru akan otomatis dibuat.');" style="flex: 1;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm w-100">Approve</button>
                                        </form>

                                        <!-- Reject Inline Toggle -->
                                        <button type="button" class="btn btn-danger btn-sm" onclick="showRejectBox({{ $p->id }})" style="flex: 1;">Reject</button>
                                    </div>

                                    <!-- Reject Form -->
                                    <div id="reject-box-{{ $p->id }}" style="display: none; margin-top: 12px; padding: 12px; border: 1px dashed var(--border); border-radius: 8px; background-color: var(--bg-light);">
                                        <form method="POST" action="{{ route('admin.pendaftaran.reject', $p->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group mb-1">
                                                <label class="form-label small">Alasan Penolakan:</label>
                                                <input type="text" name="catatan" class="form-control btn-sm" required>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end mt-2">
                                                <button type="button" class="btn btn-outline btn-sm" onclick="hideRejectBox({{ $p->id }})">Batal</button>
                                                <button type="submit" class="btn btn-danger btn-sm">Kirim Penolakan</button>
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
                            <td colspan="7" class="text-center text-muted" style="padding: 30px;">Belum ada berkas pendaftaran jemaat baru.</td>
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
function showRejectBox(id) {
    document.getElementById('reject-box-' + id).style.display = 'block';
}
function hideRejectBox(id) {
    document.getElementById('reject-box-' + id).style.display = 'none';
}
</script>
@endsection
