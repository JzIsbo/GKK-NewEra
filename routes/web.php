<?php

use App\Enums\AppRole;
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
Route::get('/persembahan/unduh-qris', [PersembahanController::class, 'downloadQris'])->name('persembahan.download-qris');

// Midtrans Webhook (no CSRF)
Route::post('/webhook/midtrans', [PersembahanController::class, 'webhook'])
    ->name('persembahan.webhook');

// PWA Static Fallbacks
Route::get('/manifest.json', function () {
    $path = public_path('manifest.json');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'application/manifest+json; charset=utf-8',
        'Access-Control-Allow-Origin' => '*',
    ]);
});

Route::get('/sw.js', function () {
    $path = public_path('sw.js');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'application/javascript; charset=utf-8',
        'Service-Worker-Allowed' => '/',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
});

Route::get('/downloads/gemindo-kk.apk', function () {
    $path = public_path('downloads/gemindo-kk.apk');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path, 'GEMINDO-Kawan-Kasih.apk', [
        'Content-Type' => 'application/vnd.android.package-archive',
        'Cache-Control' => 'public, max-age=3600, must-revalidate',
    ]);
});

Route::get('/.well-known/assetlinks.json', function () {
    $path = public_path('.well-known/assetlinks.json');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'application/json',
        'Cache-Control' => 'public, max-age=86400',
    ]);
});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:6,1');
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
        Route::resource('kegiatan', \App\Http\Controllers\KegiatanController::class)->except(['show']);
    });

    // Panitia HABERJA (Hari Besar Gereja) Routes
    Route::prefix('haberja')->name('haberja.')->group(function () {
        Route::get('/', [\App\Http\Controllers\HaberjaController::class, 'index'])->name('index');
        Route::get('/print', [\App\Http\Controllers\HaberjaController::class, 'print'])->name('print');
        Route::post('/panitia', [\App\Http\Controllers\HaberjaController::class, 'storePanitia'])->name('panitia.store');
        Route::put('/panitia/{panitia}', [\App\Http\Controllers\HaberjaController::class, 'updatePanitia'])->name('panitia.update');
        Route::delete('/panitia/{panitia}', [\App\Http\Controllers\HaberjaController::class, 'destroyPanitia'])->name('panitia.destroy');
        Route::post('/dana-plan', [\App\Http\Controllers\HaberjaController::class, 'storeDanaPlan'])->name('dana.store');
        Route::put('/dana-plan/{danaPlan}', [\App\Http\Controllers\HaberjaController::class, 'updateDanaPlan'])->name('dana.update');
        Route::delete('/dana-plan/{danaPlan}', [\App\Http\Controllers\HaberjaController::class, 'destroyDanaPlan'])->name('dana.destroy');
        Route::post('/budget', [\App\Http\Controllers\HaberjaController::class, 'storeBudget'])->name('budget.store');
        Route::put('/budget/{budget}', [\App\Http\Controllers\HaberjaController::class, 'updateBudget'])->name('budget.update');
        Route::delete('/budget/{budget}', [\App\Http\Controllers\HaberjaController::class, 'destroyBudget'])->name('budget.destroy');
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
    Route::middleware([AppRole::role(AppRole::MAJELIS_MODULE)])
        ->prefix('majelis')
        ->name('majelis.')
        ->group(function () {
            
            // Kehadiran Ibadah
            Route::middleware([AppRole::role(AppRole::KEHADIRAN_AND_PENGUMUMAN)])
                ->resource('kehadiran', \App\Http\Controllers\KehadiranIbadahController::class)->except(['show']);

            // Pendaftaran & Jadwal Ibadah
            Route::middleware([AppRole::role(AppRole::PENDAFTARAN_AND_JADWAL)])->group(function () {
                Route::get('/pendaftaran', [MajelisController::class, 'pendaftaranIndex'])->name('pendaftaran.index');
                Route::patch('/pendaftaran/{pendaftaran}/approve', [MajelisController::class, 'pendaftaranApprove'])->name('pendaftaran.approve');
                Route::patch('/pendaftaran/{pendaftaran}/reject', [MajelisController::class, 'pendaftaranReject'])->name('pendaftaran.reject');
                Route::resource('jadwal', \App\Http\Controllers\JadwalIbadahController::class)->except(['show']);
            });

            // Keuangan (Laporan & Persembahan Offline)
            Route::middleware([AppRole::role(AppRole::KEUANGAN)])->group(function () {
                Route::get('/laporan', [MajelisController::class, 'laporan'])->name('laporan');
                Route::get('/laporan/export', [MajelisController::class, 'exportLaporan'])->name('laporan.export');
                Route::resource('persembahan-offline', \App\Http\Controllers\Majelis\PersembahanOfflineController::class)->except(['show']);
                Route::resource('jenis-persembahan', \App\Http\Controllers\Majelis\JenisPersembahanController::class)->except(['show']);
            });

            // Pengumuman
            Route::middleware([AppRole::role(AppRole::KEHADIRAN_AND_PENGUMUMAN)])
                ->resource('pengumuman', \App\Http\Controllers\PengumumanController::class)->except(['show']);
        });

    // Admin Routes
    Route::middleware([AppRole::role([AppRole::SUPER_ADMIN])])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::get('/pendaftaran', [UserController::class, 'pendaftaranIndex'])->name('pendaftaran.index');
        Route::patch('/pendaftaran/{pendaftaran}/approve', [UserController::class, 'pendaftaranApprove'])->name('pendaftaran.approve');
        Route::patch('/pendaftaran/{pendaftaran}/reject', [UserController::class, 'pendaftaranReject'])->name('pendaftaran.reject');
        Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::get('/keuangan', [\App\Http\Controllers\Admin\KeuanganController::class, 'index'])->name('keuangan');
        Route::get('/keuangan/export', [\App\Http\Controllers\Admin\KeuanganController::class, 'export'])->name('keuangan.export');
    });
});
