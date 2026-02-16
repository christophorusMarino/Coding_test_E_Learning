<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/ping', function () {
        return response()->json(['message' => 'API OK']);
    });

    // PUBLIC ROUTE
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // END PUBLIC ROUTE

    // AUTH ROUTE
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // ROLE ROUTE DOSEN
    Route::middleware(['auth:sanctum', 'role:D'])->group(function () {});
    // END ROLE ROUTE DOSEN
    
    // ROLE ROUTE MAHASISWA
    Route::middleware(['auth:sanctum', 'role:M'])->group(function () {});
    // END ROLE ROUTE MAHASISWA

    // END AUTH ROUTE
});
