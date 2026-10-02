<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama', 'singkatan', 'deskripsi', 'foto', 'aktif'];

    public function anggota()
    {
        return $this->hasMany(User::class);
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }
}
