<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranJemaat extends Model
{
    protected $table = 'pendaftaran_jemaats';
    protected $fillable = [
        'nama_lengkap', 'email', 'no_telepon', 'tanggal_lahir',
        'tempat_lahir', 'jenis_kelamin', 'alamat', 'asal_gereja',
        'pekerjaan', 'alasan_bergabung', 'status', 'catatan_admin',
        'approved_by', 'approved_at', 'user_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'approved_at'   => 'datetime',
    ];

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /** User yang terbentuk setelah pendaftaran disetujui */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
