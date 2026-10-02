<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable()->after('name');
            $table->string('nomor_jemaat')->nullable()->unique()->after('nama_lengkap');
            $table->string('no_telepon', 20)->nullable()->after('nomor_jemaat');
            $table->date('tanggal_lahir')->nullable()->after('no_telepon');
            $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('jenis_kelamin');
            $table->string('foto')->nullable()->after('alamat');
            $table->enum('status_keanggotaan', ['pending', 'aktif', 'non-aktif'])->default('pending')->after('foto');
            $table->date('tanggal_baptis')->nullable()->after('status_keanggotaan');
            $table->date('tanggal_sidi')->nullable()->after('tanggal_baptis');
            $table->enum('status_pernikahan', ['belum_menikah', 'menikah', 'janda', 'duda'])->nullable()->after('tanggal_sidi');
            $table->string('pekerjaan')->nullable()->after('status_pernikahan');
            $table->unsignedBigInteger('kategori_id')->nullable()->after('pekerjaan');
            $table->text('catatan_admin')->nullable()->after('kategori_id');
            $table->timestamp('approved_at')->nullable()->after('catatan_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap', 'nomor_jemaat', 'no_telepon', 'tanggal_lahir',
                'tempat_lahir', 'jenis_kelamin', 'alamat', 'foto',
                'status_keanggotaan', 'tanggal_baptis', 'tanggal_sidi',
                'status_pernikahan', 'pekerjaan', 'kategori_id',
                'catatan_admin', 'approved_at'
            ]);
        });
    }
};
