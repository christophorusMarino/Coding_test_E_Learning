<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\SubmissionController;
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

        //DISCUSSION
        Route::get('/discussions/course/{idCourse}', [DiscussionController::class, 'list']);
        Route::post('/discussions', [DiscussionController::class, 'addData']);
        //REPLIES
        Route::post('/discussions/{id}/replies', [RepliesController::class, 'addData']);
    });

    // ROLE ROUTE DOSEN
    Route::middleware(['auth:sanctum', 'role:D'])->group(function () {
        //COURSE
        Route::post('/courses', [CourseController::class, 'addData']);
        Route::put('/courses/{id}', [CourseController::class, 'updateData']);
        Route::delete('/courses/{id}', [CourseController::class, 'deleteData']);

        //MATERI
        Route::post('/materials', [MaterialController::class, 'uploadData']);

        //ASSIGNMENT
        Route::get('/course/{courseId}/assignment', [AssignmentController::class, 'list']);
        Route::post('/assignments', [AssignmentController::class, 'addData']);

        //SUBMISSION
        Route::get('/submissions/{id}', [SubmissionController::class, 'downloadData']);
        Route::post('/submissions/{id}/score', [SubmissionController::class, 'gradeSubmission']);
    });
    // END ROLE ROUTE DOSEN

    // ROLE ROUTE MAHASISWA
    Route::middleware(['auth:sanctum', 'role:M'])->group(function () {
        //COURSE
        Route::get('/courses/student', [CourseController::class, 'studentCourseList']);
        Route::post('/courses/{id}/enroll', [CourseController::class, 'enrollStudent']);

        //MATERI
        Route::get('/materials/{id}/download', [MaterialController::class, 'downloadData']);

        //SUBMISSION
        Route::post('/submissions', [SubmissionController::class, 'uploadData']);
    });
    // END ROLE ROUTE MAHASISWA

    // END AUTH ROUTE
});
