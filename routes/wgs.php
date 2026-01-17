<?php

use App\Http\Controllers\WgController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    // WG listing
    Route::get('wgs', [WgController::class, 'index'])
        ->name('wgs.index');

    // WG creation
    Route::get('wgs/create', [WgController::class, 'create'])
        ->name('wgs.create');
    Route::post('wgs', [WgController::class, 'store'])
        ->name('wgs.store');

    // WG detail, edit, delete
    Route::get('wgs/{wg}', [WgController::class, 'show'])
        ->name('wgs.show');
    Route::get('wgs/{wg}/edit', [WgController::class, 'edit'])
        ->name('wgs.edit');
    Route::patch('wgs/{wg}', [WgController::class, 'update'])
        ->name('wgs.update');
    Route::delete('wgs/{wg}', [WgController::class, 'destroy'])
        ->name('wgs.destroy');

    // Activate WG
    Route::patch('wgs/{wg}/activate', [WgController::class, 'activate'])
        ->name('wgs.activate');
});
