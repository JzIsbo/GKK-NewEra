<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persembahan extends Model
{
    protected $table = 'persembahans';
    protected $fillable = [
        'order_id', 'user_id', 'nama_donatur', 'email_donatur',
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

    public static function generateOrderId(): string
    {
        return 'GKK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
