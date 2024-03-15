<?php

use App\Http\Controllers\{
    ProfileController,
    SelectListController,
};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\{
    ExampleController,
    KategoriController,
};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::impersonate();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'redirect_by_role'])->name('dashboard');

//SELECT LIST
Route::group(['as' => 'select_list.', 'prefix' => 'select_list', 'midleware' => 'auth'], function () {
    Route::get('/example', [SelectListController::class, 'getListExample'])
        ->name('example');
});

//Data Master
Route::group([
    'prefix' => 'master',
    'as' => 'master.',
    'midleware' => 'auth'
], function () {
    //example
    Route::get('example/data', [ExampleController::class, 'data'])
        ->name('example.data');
    Route::resource('example', ExampleController::class);

    //kategori
    Route::get('kategori/data', [KategoriController::class, 'data'])
        ->name('kategori.data');
    Route::resource('kategori', KategoriController::class);
});



Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::put('profile/foto', [ProfileController::class, 'updateFoto'])
        ->name('profile.update_foto');
    Route::put('profile/ubah_password', [ProfileController::class, 'ubahPassword'])
        ->name('profile.ubah_password');
});

require_once __DIR__ . '/auth.php';
