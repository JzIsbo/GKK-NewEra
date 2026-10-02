<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_ibadahs', function (Blueprint $table) {
            $table->string('pelayan_firman')->nullable()->after('lokasi');
            $table->string('worship_leader')->nullable()->after('pelayan_firman');
            $table->string('pemusik')->nullable()->after('worship_leader');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_ibadahs', function (Blueprint $table) {
            $table->dropColumn(['pelayan_firman', 'worship_leader', 'pemusik']);
        });
    }
};
