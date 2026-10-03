<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaberjaBudget extends Model
{
    use HasFactory;

    protected $table = 'haberja_budgets';

    protected $fillable = [
        'event_id',
        'tipe',
        'seksi',
        'uraian',
        'volume',
        'harga_satuan',
        'total_anggaran',
        'realisasi',
        'keterangan',
    ];

    protected $casts = [
        'harga_satuan'   => 'integer',
        'total_anggaran' => 'integer',
        'realisasi'      => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(HaberjaEvent::class, 'event_id');
    }

    public function getSelisihAttribute(): int
    {
        return $this->total_anggaran - $this->realisasi;
    }
}
