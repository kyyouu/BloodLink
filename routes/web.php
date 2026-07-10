<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\JadwalDonorController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PendonorController;
use App\Http\Controllers\Admin\PermintaanDarahController;
use App\Http\Controllers\Admin\RumahSakitController;
use App\Http\Controllers\Admin\StokDarahController;
use App\Http\Controllers\Pendonor\PendonorDashboardController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\Petugas\JadwalDonorController as PetugasJadwalDonorController;
use App\Http\Controllers\Petugas\ManajemenDonorController as PetugasDonorController;
use App\Http\Controllers\Pimpinan\PimpinanDashboardController;
use App\Http\Controllers\Rs\RsDashboardController;
use App\Http\Controllers\Rs\RsPermintaanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| BloodLink Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin'        => redirect()->route('admin.dashboard'),
            'petugas_pmi'  => redirect()->route('petugas.dashboard'),
            'pendonor'     => redirect()->route('pendonor.dashboard'),
            'rumah_sakit'  => redirect()->route('rs.dashboard'),
            'pimpinan_pmi' => redirect()->route('pimpinan.dashboard'),
            default        => redirect('/login'),
        };
    }
    // Tampilkan halaman landing BloodLink untuk tamu
    return view('welcome');
});

// ── ADMIN ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('pendonor',          PendonorController::class);
        Route::resource('rumah-sakit',       RumahSakitController::class);
        Route::resource('stok-darah',        StokDarahController::class);
        Route::resource('jadwal-donor',      JadwalDonorController::class);
        Route::resource('donor',             DonorController::class);
        Route::resource('permintaan-darah',  PermintaanDarahController::class);

        Route::get('laporan/donor',          [LaporanController::class, 'donor'])->name('laporan.donor');
        Route::get('laporan/donor/pdf',      [LaporanController::class, 'exportPdf'])->name('laporan.donor.pdf');
        Route::get('laporan/stok',           [LaporanController::class, 'stok'])->name('laporan.stok');

        // Manajemen User (petugas_pmi, pimpinan_pmi)
        Route::get('user',                            [UserController::class, 'index'])->name('user.index');
        Route::post('user',                           [UserController::class, 'store'])->name('user.store');
        Route::delete('user/{user}',                  [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('user/{user}/reset-password',     [UserController::class, 'resetPassword'])->name('user.reset-password');
        Route::post('user/{user}/toggle-active',      [UserController::class, 'toggleActive'])->name('user.toggle-active');
    });

// ── PETUGAS PMI ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:petugas_pmi'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
        Route::resource('pendonor',          PendonorController::class)->only(['index', 'show', 'edit', 'update']);
        Route::resource('donor',             PetugasDonorController::class)->only(['index', 'update']);
        Route::resource('stok-darah',        StokDarahController::class)->only(['index', 'edit', 'update']);
        Route::resource('jadwal-donor',      PetugasJadwalDonorController::class);
        Route::resource('permintaan-darah',  PermintaanDarahController::class);
    });

// ── PENDONOR ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:pendonor'])
    ->prefix('pendonor')
    ->name('pendonor.')
    ->group(function () {
        Route::get('/dashboard',    [PendonorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/daftar-donor', [PendonorDashboardController::class, 'daftarDonor'])->name('daftar');
        Route::post('/daftar-donor',[PendonorDashboardController::class, 'storeDaftar'])->name('daftar.store');
        Route::get('/riwayat',      [PendonorDashboardController::class, 'riwayat'])->name('riwayat');
        Route::get('/profil',       [PendonorDashboardController::class, 'profil'])->name('profil');
        Route::put('/profil',       [PendonorDashboardController::class, 'updateProfil'])->name('profil.update');
    });

// ── RUMAH SAKIT ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:rumah_sakit'])
    ->prefix('rs')
    ->name('rs.')
    ->group(function () {
        Route::get('/dashboard',  [RsDashboardController::class, 'index'])->name('dashboard');
        Route::get('/stok-darah', [RsDashboardController::class, 'stokDarah'])->name('stok');
        Route::resource('permintaan-darah', RsPermintaanController::class)
            ->only(['index', 'create', 'store', 'show']);
    });

// ── PIMPINAN PMI ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:pimpinan_pmi'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {
        Route::get('/dashboard',     [PimpinanDashboardController::class, 'index'])->name('dashboard');
        Route::get('/laporan-donor', [PimpinanDashboardController::class, 'laporanDonor'])->name('laporan.donor');
        Route::get('/laporan-stok',  [PimpinanDashboardController::class, 'laporanStok'])->name('laporan.stok');
        Route::get('/monitoring',    [PimpinanDashboardController::class, 'monitoring'])->name('monitoring');
    });

// ── AUTH (Breeze) ──────────────────────────────────────────────────────────
require __DIR__ . '/auth.php';
