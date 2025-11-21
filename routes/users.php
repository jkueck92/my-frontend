<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::middleware(['auth', 'verified', 'permission:view.users-menu'])->group(function () {

    // index
    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');

    // create
    Route::get('users/create', [UserController::class, 'create'])
        ->name('users.create');

    // show
    Route::get('users/{id}', [UserController::class, 'show'])
        ->name('users.show');

    // store
    Route::post('users', [UserController::class, 'store'])
        ->name('users.store');

    // update
    Route::patch('users/{id}', [UserController::class, 'update'])
        ->name('users.update');

    // delete
    Route::delete('users/{id}', [UserController::class, 'destroy'])
        ->name('users.destroy');

});
