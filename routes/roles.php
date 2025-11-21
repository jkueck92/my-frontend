<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;

Route::middleware(['auth', 'verified', 'permission:view.roles-menu'])->group(function () {

    // index
    Route::get('roles', [RoleController::class, 'index'])
        ->name('roles.index');

    // create
    Route::get('roles/create', [RoleController::class, 'create'])
        ->name('roles.create');

    // show
    Route::get('roles/{id}', [RoleController::class, 'show'])
        ->name('roles.show');

    // store
    Route::post('roles', [RoleController::class, 'store'])
        ->name('roles.store');

    // update
    Route::patch('roles/{id}', [RoleController::class, 'update'])
        ->name('roles.update');

    // delete
    Route::delete('roles/{id}', [RoleController::class, 'destroy'])
        ->name('roles.destroy');

});
