<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaberjaEvent extends Model
{
    use HasFactory;

    protected $table = 'haberja_events';

    protected $fillable = [
        'nama',
        'kode',
        'tahun',
        'tema',
        'ayat_tema',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'target_anggaran',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'target_anggaran' => 'integer',
        'tahun'           => 'integer',
    ];

    public function panitias()
    {
        return $this->hasMany(HaberjaPanitia::class, 'event_id')->orderBy('urutan');
    }

    public function danaPlans()
    {
        return $this->hasMany(HaberjaDanaPlan::class, 'event_id')->latest();
    }

    public function budgets()
    {
        return $this->hasMany(HaberjaBudget::class, 'event_id');
    }

    public function pengeluarans()
    {
        return $this->hasMany(HaberjaBudget::class, 'event_id')->where('tipe', 'pengeluaran');
    }

    public function pemasukans()
    {
        return $this->hasMany(HaberjaBudget::class, 'event_id')->where('tipe', 'pemasukan');
    }

    public function getTotalPengeluaranAttribute(): int
    {
        return (int) $this->pengeluarans()->sum('total_anggaran');
    }

    public function getTotalPemasukanAttribute(): int
    {
        return (int) $this->pemasukans()->sum('total_anggaran');
    }

    public function getTotalRealisasiPemasukanAttribute(): int
    {
        return (int) $this->pemasukans()->sum('realisasi');
    }

    public function getTotalRealisasiPengeluaranAttribute(): int
    {
        return (int) $this->pengeluarans()->sum('realisasi');
    }
}
