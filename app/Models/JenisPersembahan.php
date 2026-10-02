<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPersembahan extends Model
{
    protected $table = 'jenis_persembahans';
    protected $fillable = ['nama', 'deskripsi', 'aktif'];

    public function persembahans()
    {
        return $this->hasMany(Persembahan::class);
    }
}
