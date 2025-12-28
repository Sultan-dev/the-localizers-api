<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LegislationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/cards', [CardController::class, 'index']);

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Cards management
        Route::apiResource('cards', CardController::class)->except(['index']);

        // Legislations management
        Route::apiResource('legislations', LegislationController::class);
    });
});

