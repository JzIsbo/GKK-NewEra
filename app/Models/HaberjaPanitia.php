<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaberjaPanitia extends Model
{
    use HasFactory;

    protected $table = 'haberja_panitias';

    protected $fillable = [
        'event_id',
        'nama',
        'jabatan',
        'seksi',
        'telepon',
        'tugas_pokok',
        'foto',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(HaberjaEvent::class, 'event_id');
    }
}
