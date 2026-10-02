<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PersembahanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\MajelisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/daftar-jemaat', [PublicController::class, 'daftarJemaatForm'])->name('daftar-jemaat');
Route::post('/daftar-jemaat', [PublicController::class, 'daftarJemaatStore'])->name('daftar-jemaat.store');
Route::get('/daftar-jemaat/sukses', [PublicController::class, 'daftarJemaatSuccess'])->name('daftar-jemaat.success');

// Persembahan publik
Route::get('/persembahan', [PersembahanController::class, 'index'])->name('persembahan.index');
Route::post('/persembahan', [PersembahanController::class, 'store'])->name('persembahan.store');
Route::get('/persembahan/sukses/{orderId}', [PersembahanController::class, 'success'])->name('persembahan.success');
Route::get('/persembahan/bukti/{orderId}', [PersembahanController::class, 'buktiPdf'])->name('persembahan.bukti');

// Midtrans Webhook (no CSRF)
Route::post('/webhook/midtrans', [PersembahanController::class, 'webhook'])
    ->name('persembahan.webhook');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard (auto-redirect by role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kegiatan Routes
    Route::middleware(['role_or_permission:super_admin|majelis|manage-kegiatan'])->group(function () {
        Route::resource('kegiatan', \App\Http\Controllers\KegiatanController::class);
    });

    // Jemaat Routes
    Route::prefix('jemaat')->name('jemaat.')->group(function () {
        Route::get('/profil', [JemaatController::class, 'profil'])->name('profil');
        Route::put('/profil', [JemaatController::class, 'updateProfil'])->name('profil.update');
        Route::get('/kartu-jemaat', [JemaatController::class, 'kartuJemaat'])->name('kartu');
        Route::get('/persembahan/riwayat', [PersembahanController::class, 'riwayat'])->name('riwayat-persembahan');
        Route::get('/data-jemaat', [\App\Http\Controllers\JemaatDirectoryController::class, 'index'])->name('data-jemaat');
    });

    // Majelis & Kategorial Group
    Route::middleware(['role:super_admin|majelis|sekretaris_majelis|bendahara_majelis|pengurus_kategorial_kpb|pengurus_kategorial_kpw|pengurus_kategorial_kpp|pengurus_kategorial_kpr|pengurus_kategorial_kpa'])
        ->prefix('majelis')
        ->name('majelis.')
        ->group(function () {
            
            // Kehadiran Ibadah
            Route::middleware(['role:super_admin|majelis|sekretaris_majelis|pengurus_kategorial_kpb|pengurus_kategorial_kpw|pengurus_kategorial_kpp|pengurus_kategorial_kpr|pengurus_kategorial_kpa'])
                ->resource('kehadiran', \App\Http\Controllers\KehadiranIbadahController::class);

            // Pendaftaran & Jadwal Ibadah
            Route::middleware(['role:super_admin|majelis|sekretaris_majelis'])->group(function () {
                Route::get('/pendaftaran', [MajelisController::class, 'pendaftaranIndex'])->name('pendaftaran.index');
                Route::patch('/pendaftaran/{pendaftaran}/approve', [MajelisController::class, 'pendaftaranApprove'])->name('pendaftaran.approve');
                Route::patch('/pendaftaran/{pendaftaran}/reject', [MajelisController::class, 'pendaftaranReject'])->name('pendaftaran.reject');
                Route::resource('jadwal', \App\Http\Controllers\JadwalIbadahController::class);
            });

            // Keuangan (Laporan & Persembahan Offline)
            Route::middleware(['role:super_admin|majelis|bendahara_majelis'])->group(function () {
                Route::get('/laporan', [MajelisController::class, 'laporan'])->name('laporan');
                Route::get('/laporan/export', [MajelisController::class, 'exportLaporan'])->name('laporan.export');
                Route::resource('persembahan-offline', \App\Http\Controllers\Majelis\PersembahanOfflineController::class);
                Route::resource('jenis-persembahan', \App\Http\Controllers\Majelis\JenisPersembahanController::class);
            });

            // Pengumuman
            Route::middleware(['role:super_admin|majelis|sekretaris_majelis|pengurus_kategorial_kpb|pengurus_kategorial_kpw|pengurus_kategorial_kpp|pengurus_kategorial_kpr|pengurus_kategorial_kpa'])
                ->resource('pengumuman', \App\Http\Controllers\PengumumanController::class);
        });

    // Admin Routes
    Route::middleware(['role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/pendaftaran', [UserController::class, 'pendaftaranIndex'])->name('pendaftaran.index');
        Route::patch('/pendaftaran/{pendaftaran}/approve', [UserController::class, 'pendaftaranApprove'])->name('pendaftaran.approve');
        Route::patch('/pendaftaran/{pendaftaran}/reject', [UserController::class, 'pendaftaranReject'])->name('pendaftaran.reject');
        Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::get('/keuangan', [\App\Http\Controllers\Admin\KeuanganController::class, 'index'])->name('keuangan');
        Route::get('/keuangan/export', [\App\Http\Controllers\Admin\KeuanganController::class, 'export'])->name('keuangan.export');
    });
});
