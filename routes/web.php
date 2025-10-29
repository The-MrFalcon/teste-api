<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RecordController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// API routes (use the 'api' middleware group to avoid CSRF middleware)

Route::prefix('api')
    ->middleware('api')
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('patients', PatientController::class);
        Route::prefix('patients/{patient}')->group(function () {
            Route::apiResource('records', RecordController::class);
        });
    });

    Route::get('/ping', fn() => response()->json(['message' => 'pong']));
});

require __DIR__.'/settings.php';
require __DIR__.'/patients.php';
