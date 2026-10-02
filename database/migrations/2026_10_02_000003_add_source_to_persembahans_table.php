<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom 'source' ke tabel persembahans.
     *
     * Sebelumnya: filter offline menggunakan whereNull('snap_token') yang rapuh
     * — persembahan online gagal juga bisa snap_token = null.
     *
     * Setelah fix: kolom 'source' eksplisit membedakan online vs offline.
     */
    public function up(): void
    {
        Schema::table('persembahans', function (Blueprint $table) {
            $table->enum('source', ['online', 'offline'])->default('online')->after('order_id');
        });

        // Backfill data lama: tandai sebagai offline jika snap_token null
        // dan metode bayar adalah Tunai/Transfer Manual/Offline
        DB::table('persembahans')
            ->whereNull('snap_token')
            ->whereIn('metode_bayar', ['Tunai', 'Transfer Manual', 'Offline'])
            ->update(['source' => 'offline']);
    }

    public function down(): void
    {
        Schema::table('persembahans', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
