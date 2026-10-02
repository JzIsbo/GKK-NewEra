<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kategori_id ke jadwal_ibadahs
        Schema::table('jadwal_ibadahs', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
        });

        // 2. Buat tabel kehadiran_ibadahs
        Schema::create('kehadiran_ibadahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_ibadah_id')->constrained('jadwal_ibadahs')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('jumlah_pria')->default(0);
            $table->integer('jumlah_wanita')->default(0);
            $table->integer('jumlah_anak')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran_ibadahs');

        Schema::table('jadwal_ibadahs', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
