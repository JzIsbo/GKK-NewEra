<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom user_id ke pendaftaran_jemaats untuk melacak User
     * yang terbentuk setelah pendaftaran disetujui.
     *
     * Tanpa kolom ini tidak ada cara untuk menelusuri:
     * "Pendaftaran ini menghasilkan user mana?" atau sebaliknya
     * "User ini berasal dari pendaftaran mana?"
     */
    public function up(): void
    {
        Schema::table('pendaftaran_jemaats', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('approved_at')
                ->constrained('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_jemaats', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
