<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Tarif management
        Route::get('/tarifs', [AdminController::class, 'tarifs'])->name('tarifs');
        Route::get('/tarifs/create', [AdminController::class, 'createTarif'])->name('tarifs.create');
        Route::post('/tarifs', [AdminController::class, 'storeTarif'])->name('tarifs.store');
        Route::get('/tarifs/{tarif}/edit', [AdminController::class, 'editTarif'])->name('tarifs.edit');
        Route::put('/tarifs/{tarif}', [AdminController::class, 'updateTarif'])->name('tarifs.update');
        Route::delete('/tarifs/{tarif}', [AdminController::class, 'deleteTarif'])->name('tarifs.delete');

        // Area management
        Route::get('/areas', [AdminController::class, 'areas'])->name('areas');
        Route::get('/areas/create', [AdminController::class, 'createArea'])->name('areas.create');
        Route::post('/areas', [AdminController::class, 'storeArea'])->name('areas.store');
        Route::get('/areas/{area}/edit', [AdminController::class, 'editArea'])->name('areas.edit');
        Route::put('/areas/{area}', [AdminController::class, 'updateArea'])->name('areas.update');
        Route::delete('/areas/{area}', [AdminController::class, 'deleteArea'])->name('areas.delete');

        // Kendaraan management
        Route::get('/kendaraans', [AdminController::class, 'kendaraans'])->name('kendaraans');
        Route::get('/kendaraans/create', [AdminController::class, 'createKendaraan'])->name('kendaraans.create');
        Route::post('/kendaraans', [AdminController::class, 'storeKendaraan'])->name('kendaraans.store');
        Route::get('/kendaraans/{kendaraan}/edit', [AdminController::class, 'editKendaraan'])->name('kendaraans.edit');
        Route::put('/kendaraans/{kendaraan}', [AdminController::class, 'updateKendaraan'])->name('kendaraans.update');
        Route::delete('/kendaraans/{kendaraan}', [AdminController::class, 'deleteKendaraan'])->name('kendaraans.delete');

        // Logs
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    });

    // Petugas routes
    Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

        // Transaksi
        Route::get('/transaksi/masuk', [PetugasController::class, 'transaksiMasuk'])->name('transaksi.masuk');
        Route::post('/transaksi/masuk', [PetugasController::class, 'storeTransaksiMasuk'])->name('transaksi.store.masuk');
        Route::get('/transaksi/keluar', [PetugasController::class, 'transaksiKeluar'])->name('transaksi.keluar');
        Route::post('/transaksi/keluar', [PetugasController::class, 'processTransaksiKeluar'])->name('transaksi.process.keluar');
        Route::get('/transaksi/{transaksi}/struk', [PetugasController::class, 'cetakStruk'])->name('transaksi.struk');
    });

    // Owner routes
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
        Route::get('/rekap', [OwnerController::class, 'rekapTransaksi'])->name('rekap');
    });
});

Route::get('/', function () {
    return redirect()->route('login');
});
