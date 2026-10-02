<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah index yang hilang untuk query-query kritis di dashboard & laporan.
     *
     * Tanpa index ini, setiap filter by bulan/tahun, status, atau user_id
     * akan melakukan full table scan — makin lambat seiring data bertambah.
     */
    public function up(): void
    {
        // === persembahans ===
        // Query paling sering: WHERE status = 'success' AND MONTH(paid_at) = ? AND YEAR(paid_at) = ?
        // + WHERE user_id = ? (riwayat jemaat)
        Schema::table('persembahans', function (Blueprint $table) {
            $table->index('status',   'idx_persembahans_status');
            $table->index('paid_at',  'idx_persembahans_paid_at');
            $table->index('user_id',  'idx_persembahans_user_id');
            $table->index('source',   'idx_persembahans_source');
            // Composite: paling sering dikombinasikan di dashboard
            $table->index(['status', 'paid_at'], 'idx_persembahans_status_paid_at');
        });

        // === users ===
        // Query: WHERE status_keanggotaan = 'aktif', WHERE kategori_id = ?, role queries via Spatie
        Schema::table('users', function (Blueprint $table) {
            $table->index('status_keanggotaan', 'idx_users_status_keanggotaan');
            $table->index('kategori_id',        'idx_users_kategori_id');
        });

        // === kehadiran_ibadahs ===
        // Query: WHERE tanggal BETWEEN ?, ORDER BY tanggal DESC
        Schema::table('kehadiran_ibadahs', function (Blueprint $table) {
            $table->index('tanggal',          'idx_kehadiran_tanggal');
            $table->index('jadwal_ibadah_id', 'idx_kehadiran_jadwal_id');
        });

        // === kegiatans ===
        // Query: WHERE aktif = true AND tanggal_mulai >= now()
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->index(['aktif', 'tanggal_mulai'], 'idx_kegiatans_aktif_mulai');
            $table->index('kategori_id', 'idx_kegiatans_kategori_id');
        });

        // === pengumuman ===
        // Query: WHERE aktif = true AND (tanggal_selesai IS NULL OR tanggal_selesai >= now())
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->index(['aktif', 'tanggal_selesai'], 'idx_pengumuman_aktif_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('persembahans', function (Blueprint $table) {
            $table->dropIndex('idx_persembahans_status');
            $table->dropIndex('idx_persembahans_paid_at');
            $table->dropIndex('idx_persembahans_user_id');
            $table->dropIndex('idx_persembahans_source');
            $table->dropIndex('idx_persembahans_status_paid_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_status_keanggotaan');
            $table->dropIndex('idx_users_kategori_id');
        });

        Schema::table('kehadiran_ibadahs', function (Blueprint $table) {
            $table->dropIndex('idx_kehadiran_tanggal');
            $table->dropIndex('idx_kehadiran_jadwal_id');
        });

        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropIndex('idx_kegiatans_aktif_mulai');
            $table->dropIndex('idx_kegiatans_kategori_id');
        });

        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropIndex('idx_pengumuman_aktif_selesai');
        });
    }
};
