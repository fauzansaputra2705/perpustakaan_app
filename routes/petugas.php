<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petugas\{
    DashboardController,
    PeminjamanController,
};
use App\Http\Controllers\ProfileController;

Route::group([
    'prefix' => 'petugas',
    'middleware' => 'role:petugas',
    'as' => 'petugas.'
], function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    //peminjam
    Route::get('/peminjam', [PeminjamanController::class, 'index'])->name('peminjam.index');
    Route::get('/peminjam/data', [PeminjamanController::class, 'data'])
        ->name('peminjam.data');
    Route::post('/peminjam/store', [PeminjamanController::class, 'store'])->name('peminjam.store');
});
