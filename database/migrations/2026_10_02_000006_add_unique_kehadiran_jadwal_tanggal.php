<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah unique constraint pada (jadwal_ibadah_id, tanggal) di kehadiran_ibadahs.
     *
     * Tanpa constraint ini, satu jadwal di tanggal yang sama bisa diinput berkali-kali
     * sehingga laporan kehadiran menjadi double-count.
     *
     * Sebelum membuat constraint, data duplikat dibersihkan terlebih dulu
     * (simpan yang terbaru, hapus yang lama).
     */
    public function up(): void
    {
        // Hapus baris duplikat — pertahankan yang id-nya paling besar (terbaru).
        // Menggunakan subquery ANSI SQL yang kompatibel dengan SQLite, MySQL, dan PostgreSQL.
        DB::table('kehadiran_ibadahs')
            ->whereNotIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('kehadiran_ibadahs')
                    ->groupBy('jadwal_ibadah_id', 'tanggal');
            })
            ->delete();

        Schema::table('kehadiran_ibadahs', function (Blueprint $table) {
            $table->unique(['jadwal_ibadah_id', 'tanggal'], 'kehadiran_unique_jadwal_tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('kehadiran_ibadahs', function (Blueprint $table) {
            $table->dropUnique('kehadiran_unique_jadwal_tanggal');
        });
    }
};
