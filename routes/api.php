<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RecordController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('patients', PatientController::class);
    Route::put('patients/{id}/restore', [PatientController::class, 'restore']);
    Route::delete('patients/{id}/force', [PatientController::class, 'forceDelete']);

    Route::prefix('patients/{patient}')->group(function () {
        Route::apiResource('records', RecordController::class);
        Route::put('records/{record}/restore', [RecordController::class, 'restore']);
        Route::delete('records/{record}/force', [RecordController::class, 'forceDelete']);
    });
});

Route::get('/ping', fn () => response()->json(['message' => 'pong']));


