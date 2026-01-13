<?php

use Illuminate\Support\Facades\Route;

// Serve static storage files from public/storage directory
Route::get('/storage/{path}', function ($path) {
    $fullPath = public_path('storage/' . $path);
    
    if (!file_exists($fullPath)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.serve');

Route::get('/', function () {
    return response()->json(['message' => 'API Server Running']);
});
