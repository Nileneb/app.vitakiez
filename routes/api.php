<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\WgController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\SourceEvidenceController;

Route::post('/auth/token', [AuthTokenController::class, 'issueToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wgs', [WgController::class, 'index']);
    Route::post('/wgs', [WgController::class, 'store']);

    Route::get('/wgs/active', [WgController::class, 'getActive']);
    Route::post('/wgs/active', [WgController::class, 'setActive']);

    Route::post('/cases', [CaseController::class, 'store']);
    Route::post('/cases/{case}/evidence', [SourceEvidenceController::class, 'bulkUpsert']);
});
