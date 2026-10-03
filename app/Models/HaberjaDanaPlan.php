<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaberjaDanaPlan extends Model
{
    use HasFactory;

    protected $table = 'haberja_dana_plans';

    protected $fillable = [
        'event_id',
        'nama_program',
        'deskripsi',
        'target_dana',
        'realisasi_dana',
        'tanggal_mulai',
        'tanggal_selesai',
        'penanggung_jawab',
        'status',
        'catatan',
    ];

    protected $casts = [
        'target_dana'     => 'integer',
        'realisasi_dana'  => 'integer',
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function event()
    {
        return $this->belongsTo(HaberjaEvent::class, 'event_id');
    }

    public function getPersentaseAttribute(): float
    {
        if ($this->target_dana <= 0) {
            return 0;
        }
        return min(100, round(($this->realisasi_dana / $this->target_dana) * 100, 1));
    }
}
