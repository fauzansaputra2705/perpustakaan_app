<?php

use App\Http\Controllers\{
    ProfileController,
    SelectListController,
};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\{
    AnggotaController,
    BukuController,
    ExampleController,
    KategoriController,
    KelasController,
    PetugasController,
    RakBukuController,
    TarifDendaController,
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

    Route::get('/kategori', [SelectListController::class, 'getListKategori'])
        ->name('kategori');

    Route::get('/rak_buku', [SelectListController::class, 'getListRakBuku'])
        ->name('rak_buku');

    Route::get('/kelas', [SelectListController::class, 'getListKelas'])
        ->name('kelas');

    Route::get('/anggota', [SelectListController::class, 'getListAnggota'])
        ->name('anggota');

    Route::get('/buku', [SelectListController::class, 'getListBuku'])
        ->name('buku');

    Route::get('/buku-peminjam/{anggotaId}', [SelectListController::class, 'getListBukuPeminjam'])
        ->name('buku_peminjam');
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

    //rak_buku
    Route::get('rak_buku/data', [RakBukuController::class, 'data'])
        ->name('rak_buku.data');
    Route::resource('rak_buku', RakBukuController::class);

    //tarif_denda
    Route::get('tarif_denda/data', [TarifDendaController::class, 'data'])
        ->name('tarif_denda.data');
    Route::resource('tarif_denda', TarifDendaController::class);

    //kelas
    Route::get('kelas/data', [KelasController::class, 'data'])
        ->name('kelas.data');
    Route::resource('kelas', KelasController::class);

    //buku
    Route::get('buku/data', [BukuController::class, 'data'])
        ->name('buku.data');
    Route::resource('buku', BukuController::class);

    //petugas
    Route::get('petugas/data', [PetugasController::class, 'data'])
        ->name('petugas.data');
    Route::resource('petugas', PetugasController::class);

    //anggota
    Route::get('anggota/data', [AnggotaController::class, 'data'])
        ->name('anggota.data');
    Route::resource('anggota', AnggotaController::class);
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
