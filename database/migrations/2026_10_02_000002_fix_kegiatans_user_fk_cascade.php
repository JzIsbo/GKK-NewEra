<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mengubah FK kegiatans.user_id dari CASCADE DELETE menjadi SET NULL.
     *
     * Sebelumnya: hapus user penulis → semua kegiatan yang ia buat IKUT TERHAPUS.
     * Setelah fix: hapus user → kegiatan tetap ada, user_id menjadi null.
     */
    public function up(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
