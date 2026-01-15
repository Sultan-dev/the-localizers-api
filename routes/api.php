<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LegislationController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Public routes
Route::get('/cards', [CardController::class, 'index']);

// Storage file serving route (fallback if public/storage symlink doesn't exist)
Route::get('/storage/{path}', function ($path) {
    $fullPath = public_path('storage/' . $path);
    
    if (!file_exists($fullPath)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    
    return response()->file($fullPath);
})->where('path', '.*');

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Cards management
        Route::get('/cards/{id}', [CardController::class, 'show']);
        Route::post('/cards', [CardController::class, 'store']);
        Route::post('/cards/{id}', [CardController::class, 'update']);
        Route::delete('/cards/{id}', [CardController::class, 'destroy']);

        // Cloud Storage management
        Route::prefix('storage')->group(function () {
            Route::get('/cards/list', [StorageController::class, 'listCardImages']);
            Route::post('/signed-url', [StorageController::class, 'getSignedUrl']);
            Route::post('/delete', [StorageController::class, 'deleteImage']);
            Route::post('/info', [StorageController::class, 'getImageInfo']);
        });

        // Legislations management
        Route::apiResource('legislations', LegislationController::class);
    });
});


