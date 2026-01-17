<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\SourceEvidenceController;
use App\Http\Controllers\Api\WgController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/token', [AuthTokenController::class, 'issueToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wgs', [WgController::class, 'index']);
    Route::post('/wgs', [WgController::class, 'store']);
    Route::get('/wgs/{wg}', [WgController::class, 'show']);           // ← READ
    Route::put('/wgs/{wg}', [WgController::class, 'update']);         // ← UPDATE
    Route::delete('/wgs/{wg}', [WgController::class, 'destroy']);     // ← DELETE (bonus)

    Route::get('/wgs/active', [WgController::class, 'getActive']);
    Route::post('/wgs/active', [WgController::class, 'setActive']);

    Route::post('/cases', [CaseController::class, 'store']);
    Route::post('/cases/{case}/evidence', [SourceEvidenceController::class, 'bulkUpsert']);
});
