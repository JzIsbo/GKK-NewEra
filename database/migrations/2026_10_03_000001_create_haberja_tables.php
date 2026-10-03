<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('haberja_events', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode', 50)->unique();
            $table->integer('tahun')->default(2026);
            $table->string('tema')->nullable();
            $table->string('ayat_tema')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->bigInteger('target_anggaran')->default(0);
            $table->string('status', 50)->default('aktif');
            $table->timestamps();
        });

        Schema::create('haberja_panitias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained('haberja_events')->nullOnDelete();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('seksi');
            $table->string('telepon', 50)->nullable();
            $table->text('tugas_pokok')->nullable();
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('haberja_dana_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained('haberja_events')->nullOnDelete();
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
            $table->bigInteger('target_dana')->default(0);
            $table->bigInteger('realisasi_dana')->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->string('status', 50)->default('berjalan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('haberja_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('haberja_events')->cascadeOnDelete();
            $table->enum('tipe', ['pengeluaran', 'pemasukan'])->default('pengeluaran');
            $table->string('seksi');
            $table->string('uraian');
            $table->string('volume')->nullable();
            $table->bigInteger('harga_satuan')->default(0);
            $table->bigInteger('total_anggaran')->default(0);
            $table->bigInteger('realisasi')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haberja_budgets');
        Schema::dropIfExists('haberja_dana_plans');
        Schema::dropIfExists('haberja_panitias');
        Schema::dropIfExists('haberja_events');
    }
};
