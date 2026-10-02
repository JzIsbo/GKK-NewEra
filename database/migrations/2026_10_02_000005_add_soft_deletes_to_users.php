<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom deleted_at untuk SoftDeletes di tabel users.
     *
     * Dengan SoftDeletes:
     * - User::delete() → set deleted_at, TIDAK hapus dari DB
     * - Semua query Eloquent otomatis exclude soft-deleted users
     * - Data relasi (persembahan, kehadiran, dll) tetap aman
     * - Bisa di-restore jika terhapus tidak sengaja
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
