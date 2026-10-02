<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
        'nama_lengkap', 'nomor_jemaat', 'no_telepon',
        'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin',
        'alamat', 'foto', 'status_keanggotaan',
        'tanggal_baptis', 'tanggal_sidi', 'status_pernikahan',
        'pekerjaan', 'kategori_id', 'catatan_admin', 'approved_at',
        'keluarga_id', 'hubungan_keluarga',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'tanggal_lahir'     => 'date',
            'tanggal_baptis'    => 'date',
            'tanggal_sidi'      => 'date',
            'approved_at'       => 'datetime',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public function persembahans()
    {
        return $this->hasMany(Persembahan::class);
    }

    public function getNamaDisplayAttribute(): string
    {
        return $this->nama_lengkap ?: $this->name;
    }

    public function getIsAktifAttribute(): bool
    {
        return $this->status_keanggotaan === 'aktif';
    }

    // Generate nomor jemaat otomatis
    public static function generateNomorJemaat(): string
    {
        $lastUser = self::whereNotNull('nomor_jemaat')->orderByDesc('nomor_jemaat')->first();
        $lastNumber = $lastUser ? (int) substr($lastUser->nomor_jemaat, 3) : 0;
        return 'GKK' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }
}
