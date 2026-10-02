<?php

namespace App\Enums;

/**
 * Konstanta untuk semua role yang digunakan di aplikasi GKK.
 *
 * Dipakai sebagai satu sumber kebenaran — tidak ada lagi role string
 * yang tersebar dan hardcoded di berbagai controller, seeder, dan middleware.
 *
 * Penggunaan:
 *   $user->hasAnyRole(AppRole::KATEGORIAL)
 *   $user->hasRole(AppRole::SUPER_ADMIN)
 *   Route::middleware(['role:' . AppRole::SUPER_ADMIN])
 */
final class AppRole
{
    // === Core roles ===
    const SUPER_ADMIN = 'super_admin';
    const MAJELIS     = 'majelis';
    const JEMAAT      = 'jemaat';

    // === Majelis spesifik ===
    const SEKRETARIS_MAJELIS = 'sekretaris_majelis';
    const BENDAHARA_MAJELIS  = 'bendahara_majelis';

    // === Pengurus Kategorial (granular) ===
    const PENGURUS_KPB = 'pengurus_kategorial_kpb'; // Pria/Bapak
    const PENGURUS_KPW = 'pengurus_kategorial_kpw'; // Perempuan/Wanita
    const PENGURUS_KPP = 'pengurus_kategorial_kpp'; // Pemuda
    const PENGURUS_KPR = 'pengurus_kategorial_kpr'; // Remaja
    const PENGURUS_KPA = 'pengurus_kategorial_kpa'; // Anak (Sekolah Minggu)

    /**
     * Semua role pengurus kategorial — untuk hasAnyRole() check.
     * @return string[]
     */
    const KATEGORIAL = [
        self::PENGURUS_KPB,
        self::PENGURUS_KPW,
        self::PENGURUS_KPP,
        self::PENGURUS_KPR,
        self::PENGURUS_KPA,
    ];

    /**
     * Role yang memiliki akses ke seluruh kategori (tidak di-scope).
     * @return string[]
     */
    const FULL_ACCESS = [
        self::SUPER_ADMIN,
        self::MAJELIS,
        self::SEKRETARIS_MAJELIS,
    ];

    /**
     * Role yang dapat mengakses dashboard & modul operasional majelis.
     * @return string[]
     */
    const MAJELIS_MODULE = [
        self::SUPER_ADMIN,
        self::MAJELIS,
        self::SEKRETARIS_MAJELIS,
        self::BENDAHARA_MAJELIS,
        self::PENGURUS_KPB,
        self::PENGURUS_KPW,
        self::PENGURUS_KPP,
        self::PENGURUS_KPR,
        self::PENGURUS_KPA,
    ];

    /**
     * Role pengelola kehadiran & pengumuman.
     * @return string[]
     */
    const KEHADIRAN_AND_PENGUMUMAN = [
        self::SUPER_ADMIN,
        self::MAJELIS,
        self::SEKRETARIS_MAJELIS,
        self::PENGURUS_KPB,
        self::PENGURUS_KPW,
        self::PENGURUS_KPP,
        self::PENGURUS_KPR,
        self::PENGURUS_KPA,
    ];

    /**
     * Role pengelola pendaftaran & jadwal.
     * @return string[]
     */
    const PENDAFTARAN_AND_JADWAL = [
        self::SUPER_ADMIN,
        self::MAJELIS,
        self::SEKRETARIS_MAJELIS,
    ];

    /**
     * Role pengelola keuangan & persembahan.
     * @return string[]
     */
    const KEUANGAN = [
        self::SUPER_ADMIN,
        self::MAJELIS,
        self::BENDAHARA_MAJELIS,
    ];

    /**
     * Helper membuat string parameter middleware spatie 'role:...'.
     *
     * @param string[] $roles
     * @return string
     */
    public static function role(array $roles): string
    {
        return 'role:' . implode('|', $roles);
    }
}
