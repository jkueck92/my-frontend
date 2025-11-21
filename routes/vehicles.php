<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VehicleController;

Route::middleware(['auth', 'verified', 'permission:view.vehicles-menu'])->group(function () {

    // index
    Route::get('vehicles', [VehicleController::class, 'index'])
        ->name('vehicles.index');

    // create
    Route::get('vehicles/create', [VehicleController::class, 'create'])
        ->middleware(['permission:vehicles.create'])
        ->name('vehicles.create');

    // show
    Route::get('vehicles/{id}', [VehicleController::class, 'show'])
        ->name('vehicles.show');
    
    // store
    Route::post('vehicles', [VehicleController::class, 'store'])
        ->middleware(['permission:vehicles.create'])
        ->name('vehicles.store');

    // update
    Route::patch('vehicles/{id}', [VehicleController::class, 'update'])
        ->middleware(['permission:vehicles.edit'])
        ->name('vehicles.update');

    // delete
    Route::delete('vehicles/{id}', [VehicleController::class, 'destroy'])
        ->middleware(['permission:vehicles.delete'])
        ->name('vehicles.destroy');

});
