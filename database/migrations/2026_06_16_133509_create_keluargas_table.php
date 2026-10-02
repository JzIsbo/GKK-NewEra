<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel keluargas
        Schema::create('keluargas', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk')->nullable();
            $table->string('nama_keluarga');
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->timestamps();
        });

        // 2. Tambahkan kolom relasi ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('keluarga_id')->nullable()->constrained('keluargas')->onDelete('set null');
            $table->string('hubungan_keluarga')->nullable(); // Kepala Keluarga, Istri, Anak, dll
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['keluarga_id']);
            $table->dropColumn(['keluarga_id', 'hubungan_keluarga']);
        });

        Schema::dropIfExists('keluargas');
    }
};
