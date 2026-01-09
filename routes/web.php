<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// هاد route موجود أصلاً في Sanctum، بس تأكد إنه هنا
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});
Route::post('/login', [AuthController::class, 'login']);
