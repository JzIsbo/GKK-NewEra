<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'lokasi', 'tanggal_mulai', 'tanggal_selesai', 'kategori_id', 'user_id', 'aktif'];

    protected $casts = [
        'tanggal_mulai'   => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penulis()
    {
        // user_id nullable (onDelete SET NULL) — relasi bisa return null
        return $this->belongsTo(User::class, 'user_id')->withDefault(['nama_lengkap' => 'Admin (dihapus)']);
    }
}
