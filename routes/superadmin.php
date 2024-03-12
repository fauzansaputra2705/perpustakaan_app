<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\{
    DashboardController,
    DetailPendaftaranController,
    UserController,
    PendaftaranController,
    KuotaPendaftaran,
    RoleController,
};

Route::group([
    'prefix' => 'superadmin',
    'middleware' => 'role:superadmin',
    'as' => 'superadmin.'
], function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Role
    Route::get('/role', [RoleController::class, 'index'])
        ->name('role.index');
    Route::post('/role/permission/{role}', [RoleController::class, 'setRolePermissions'])
        ->name('role.set_permissions');

    //Manajemen User
    Route::group([
        'prefix' => 'manajemen_user',
        'as' => 'manajemen_user.'
    ], function () {
        //Data Akun
        Route::get('/user/data', [UserController::class, 'data'])
            ->name('user.data');
        Route::resource('user', UserController::class)->except('create');
    });
});
