<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluargas';

    protected $fillable = [
        'no_kk',
        'nama_keluarga',
        'alamat',
        'no_telepon',
    ];

    public function anggota()
    {
        return $this->hasMany(User::class, 'keluarga_id');
    }

    public function getKepalaKeluargaAttribute()
    {
        return $this->anggota()->where('hubungan_keluarga', 'Kepala Keluarga')->first();
    }
}
