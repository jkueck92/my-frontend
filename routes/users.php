<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::middleware(['auth', 'verified', 'permission:view.users-menu'])->group(function () {

    // index
    Route::get('users', [UserController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('users.index');

    // create
    Route::get('users/create', [UserController::class, 'create'])
        ->middleware(['auth', 'verified'])
        ->name('users.create');

    // show
    Route::get('users/{id}', [UserController::class, 'show'])
        ->middleware(['auth', 'verified'])
        ->name('users.show');

    // store
    Route::post('users', [UserController::class, 'store'])
        ->middleware(['auth', 'verified'])
        ->name('users.store');

    // update
    Route::patch('users/{id}', [UserController::class, 'update'])
        ->middleware(['auth', 'verified'])
        ->name('users.update');

    // delete
    Route::delete('users/{id}', [UserController::class, 'destroy'])
        ->middleware(['auth', 'verified'])
        ->name('users.destroy');

});
