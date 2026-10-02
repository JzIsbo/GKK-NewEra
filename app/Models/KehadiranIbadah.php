<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranIbadah extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_ibadahs';

    protected $fillable = [
        'jadwal_ibadah_id',
        'tanggal',
        'jumlah_pria',
        'jumlah_wanita',
        'jumlah_anak',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jadwalIbadah()
    {
        return $this->belongsTo(JadwalIbadah::class, 'jadwal_ibadah_id');
    }

    public function getTotalKehadiranAttribute(): int
    {
        return ($this->jumlah_pria ?? 0) + ($this->jumlah_wanita ?? 0) + ($this->jumlah_anak ?? 0);
    }
}
