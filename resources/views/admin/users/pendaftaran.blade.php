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
            <table>
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
                            <td>
                                <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                                <div class="text-muted small">Pekerjaan: {{ $p->pekerjaan ?: '-' }}</div>
                            </td>
                            <td>
                                <div>{{ $p->email }}</div>
                                <div class="text-muted small">{{ $p->no_telepon }}</div>
                            </td>
                            <td>{{ $p->asal_regex ?: ($p->asal_gereja ?: '-') }}</td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($p->status === 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($p->status === 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-danger small">{{ $p->catatan_admin ?: '-' }}</span>
                            </td>
                            <td>
                                @if($p->status === 'pending')
                                    <div class="d-flex gap-2">
                                        <!-- Approve Form -->
                                        <form method="POST" action="{{ route('admin.pendaftaran.approve', $p->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini? User baru akan otomatis dibuat.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>

                                        <!-- Reject Inline Toggle -->
                                        <button type="button" class="btn btn-danger btn-sm" onclick="showRejectBox({{ $p->id }})">Reject</button>
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
                                            <div class="text-end">
                                                <button type="button" class="btn btn-outline btn-sm" onclick="hideRejectBox({{ $p->id }})" style="padding: 3px 8px;">Batal</button>
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px;">Kirim</button>
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
                            <td colspan="7" class="text-center text-muted">Belum ada berkas pendaftaran jemaat baru.</td>
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
