<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan FK constraint yang hilang: users.kategori_id → kategoris.id
     *
     * Migration awal (update_users_table) hanya mendefinisikan kolom sebagai
     * unsignedBigInteger tanpa foreign key — tidak ada referential integrity.
     * Akibatnya users bisa punya kategori_id yang tidak ada di tabel kategoris
     * (data phantom), dan relasi User::kategori() silently return null.
     *
     * Sebelum menambahkan constraint, data orphan dibersihkan terlebih dulu
     * agar migration tidak gagal karena pelanggaran FK.
     */
    public function up(): void
    {
        // Bersihkan data orphan sebelum buat constraint
        // (set null jika kategori_id tidak ada di tabel kategoris)
        DB::statement('
            UPDATE users
            SET kategori_id = NULL
            WHERE kategori_id IS NOT NULL
              AND kategori_id NOT IN (SELECT id FROM kategoris)
        ');

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategoris')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
        });
    }
};
