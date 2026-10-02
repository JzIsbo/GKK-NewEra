<?php

namespace App\Services;

use App\Models\PendaftaranJemaat;
use App\Models\User;
use App\Notifications\JemaatDisetujuiNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * PendaftaranService
 *
 * Enkapsulasi business logic untuk approval dan penolakan pendaftaran jemaat.
 * Sebelumnya logika ini ada di AdminUserController dan dipanggil langsung
 * oleh MajelisController via app(AdminUserController::class) — anti-pattern.
 *
 * Dengan Service ini, kedua controller cukup memanggil:
 *   $this->service->approve($pendaftaran)
 *   $this->service->reject($pendaftaran, $catatan)
 */
class PendaftaranService
{
    /**
     * Setujui pendaftaran: buat akun User, assign role, update status pendaftaran.
     *
     * @return array{user: User, password: string}
     */
    public function approve(PendaftaranJemaat $pendaftaran): array
    {
        return DB::transaction(function () use ($pendaftaran) {
            $password = Str::random(10);

            $user = User::create([
                'name'               => $pendaftaran->nama_lengkap,
                'nama_lengkap'       => $pendaftaran->nama_lengkap,
                'email'              => $pendaftaran->email,
                'no_telepon'         => $pendaftaran->no_telepon,
                'tanggal_lahir'      => $pendaftaran->tanggal_lahir,
                'tempat_lahir'       => $pendaftaran->tempat_lahir,
                'jenis_kelamin'      => $pendaftaran->jenis_kelamin,
                'alamat'             => $pendaftaran->alamat,
                'pekerjaan'          => $pendaftaran->pekerjaan,
                'password'           => Hash::make($password),
                'status_keanggotaan' => 'aktif',
                'nomor_jemaat'       => User::generateNomorJemaat(),
                'approved_at'        => now(),
                'email_verified_at'  => now(),
            ]);

            $user->assignRole('jemaat');

            $pendaftaran->update([
                'status'      => 'disetujui',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'user_id'     => $user->id,
            ]);

            // Kirim email notifikasi dengan kredensial ke jemaat baru
            try {
                $user->notify(new JemaatDisetujuiNotification($password));
            } catch (\Throwable $e) {
                Log::warning("Gagal mengirim email aktivasi ke {$user->email}: {$e->getMessage()}");
            }

            return compact('user', 'password');
        });
    }

    /**
     * Tolak pendaftaran: update status dan simpan catatan admin.
     */
    public function reject(PendaftaranJemaat $pendaftaran, ?string $catatan): void
    {
        $pendaftaran->update([
            'status'        => 'ditolak',
            'catatan_admin' => $catatan,
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
        ]);
    }
}
