-- Active: 1765016626043@@127.0.0.1@5432@n8n
<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\SourceEvidenceController;
use App\Http\Controllers\Api\WgController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/token', [AuthTokenController::class, 'issueToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wgs', [WgController::class, 'index']);
    Route::get('/wgs/{wg}', [WgController::class, 'show']);
    Route::put('/wgs/{wg}', [WgController::class, 'update']);
    Route::delete('/wgs/{wg}', [WgController::class, 'destroy']);

    Route::get('/wgs/active', [WgController::class, 'getActive']);
    Route::post('/wgs/active', [WgController::class, 'setActive']);
});

// n8n webhook routes with dedicated auth
Route::middleware('auth.n8n')->group(function () {
    Route::post('/wgs', [WgController::class, 'store']);
    Route::post('/cases', [CaseController::class, 'store']);
    Route::post('/cases/{case}/evidence', [SourceEvidenceController::class, 'bulkUpsert']);
});
