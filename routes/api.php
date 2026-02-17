<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MaterialController;
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

        //COURSE
        Route::get('/courses', [CourseController::class, 'list']);
    });

    // ROLE ROUTE DOSEN
    Route::middleware(['auth:sanctum', 'role:D'])->group(function () {
        //COURSE
        Route::post('/courses', [CourseController::class, 'addData']);
        Route::put('/courses/{id}', [CourseController::class, 'updateData']);
        Route::delete('/courses/{id}', [CourseController::class, 'deleteData']);

        //MATERI
        Route::post('/materials', [MaterialController::class, 'uploadData']);
    });
    // END ROLE ROUTE DOSEN

    // ROLE ROUTE MAHASISWA
    Route::middleware(['auth:sanctum', 'role:M'])->group(function () {
        //COURSE
        Route::get('/courses/student', [CourseController::class, 'studentCourseList']);
        Route::post('/courses/{id}/enroll', [CourseController::class, 'enrollStudent']);

        //MATERI
        Route::get('/materials/{id}/download', [MaterialController::class, 'downloadData']);
    });
    // END ROLE ROUTE MAHASISWA

    // END AUTH ROUTE
});
