<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalIbadah extends Model
{
    protected $table = 'jadwal_ibadahs';
    protected $fillable = ['nama', 'jenis', 'hari', 'waktu_mulai', 'waktu_selesai', 'lokasi', 'pelayan_firman', 'worship_leader', 'pemusik', 'pengajar', 'keterangan', 'aktif', 'kategori_id'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(KehadiranIbadah::class, 'jadwal_ibadah_id');
    }
}
