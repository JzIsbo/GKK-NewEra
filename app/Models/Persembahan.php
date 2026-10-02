<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persembahan extends Model
{
    protected $table = 'persembahans';
    protected $fillable = [
        'order_id', 'source', 'user_id', 'nama_donatur', 'email_donatur',
        'jenis_persembahan_id', 'nominal', 'metode_bayar',
        'status', 'snap_token', 'payment_url',
        'midtrans_transaction_id', 'paid_at', 'keterangan',
    ];

    protected $casts = [
        'nominal'  => 'decimal:2',
        'paid_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisPersembahan()
    {
        return $this->belongsTo(JenisPersembahan::class);
    }

    public function getNamaLengkapDonaturAttribute(): string
    {
        if ($this->user) {
            return $this->user->nama_lengkap ?: $this->user->name;
        }
        return $this->nama_donatur ?: 'Anonim';
    }

    public function getIsSuccessAttribute(): bool
    {
        return $this->status === 'success';
    }

    public function getIsOfflineAttribute(): bool
    {
        return $this->source === 'offline';
    }

    public function scopeOnline($query)
    {
        return $query->where('source', 'online');
    }

    public function scopeOffline($query)
    {
        return $query->where('source', 'offline');
    }

    // =========================================================
    // Query Scopes — digunakan bersama di KeuanganController
    // dan MajelisController untuk menghindari duplikasi query
    // =========================================================

    /** Filter hanya transaksi sukses */
    public function scopeSukses($query)
    {
        return $query->where('status', 'success');
    }

    /** Filter berdasarkan bulan dan tahun dari kolom paid_at */
    public function scopeBulanTahun($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('paid_at', $bulan)->whereYear('paid_at', $tahun);
    }

    /**
     * Rekap total per jenis persembahan — dihitung di DB level (bukan PHP groupBy).
     * Menghindari load semua baris ke memory hanya untuk agregasi.
     *
     * @return \Illuminate\Support\Collection<int, array{nama: string, total: float, count: int}>
     */
    public static function rekapPerJenis(int $bulan, int $tahun): \Illuminate\Support\Collection
    {
        return self::sukses()
            ->bulanTahun($bulan, $tahun)
            ->join('jenis_persembahans', 'persembahans.jenis_persembahan_id', '=', 'jenis_persembahans.id')
            ->selectRaw('jenis_persembahans.nama, SUM(persembahans.nominal) as total, COUNT(*) as count')
            ->groupBy('jenis_persembahans.id', 'jenis_persembahans.nama')
            ->orderBy('total', 'desc')
            ->get()
            ->map(fn ($r) => [
                'nama'  => $r->nama,
                'total' => (float) $r->total,
                'count' => $r->count,
            ]);
    }

    public static function generateOrderId(): string
    {
        return 'GKK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
