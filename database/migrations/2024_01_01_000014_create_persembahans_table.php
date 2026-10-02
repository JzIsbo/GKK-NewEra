<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_persembahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Persembahan Umum, Perpuluhan, Pembangunan, Diakonia, Misi, dll
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('persembahans', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // GKK-20240101-XXXX
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // null jika tamu
            $table->string('nama_donatur')->nullable(); // untuk tamu
            $table->string('email_donatur')->nullable();
            $table->foreignId('jenis_persembahan_id')->constrained('jenis_persembahans')->onDelete('cascade');
            $table->decimal('nominal', 15, 2);
            $table->string('metode_bayar')->nullable(); // gopay, bca_va, bni_va, qris, dll
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'cancel'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persembahans');
        Schema::dropIfExists('jenis_persembahans');
    }
};
