<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_ibadahs', function (Blueprint $table) {
            $table->string('jenis', 50)->default('reguler')->change();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_ibadahs', function (Blueprint $table) {
            // Revert back to enum if rolled back
            $table->enum('jenis', ['reguler', 'khusus'])->default('reguler')->change();
        });
    }
};
