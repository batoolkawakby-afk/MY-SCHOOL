<?php

use App\Http\Controllers\CounselerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\userController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('manager')->group(function () {
        Route::post('/register', [ManagerController::class, 'registerManager']);
    }); 
        Route::prefix('counseler')->group(function () {
        Route::post('/register', [CounselerController::class, 'registerCounseler']);
    });
    Route::prefix('student')->group(function () {
        Route::post('/register', [StudentController::class, 'registerStudent']);
    });
    Route::prefix('teacher')->group(function () {
        Route::post('/register', [TeacherController::class, 'registerTeacher']);
    }); 
    Route::prefix('subject')->group(function () {
    Route::post('/store', [SubjectController::class, 'store']);
    Route::get('/index', [SubjectController::class, 'index']);
});

    Route::post('/login', [userController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [userController::class, 'logout']);
});

Route::prefix('schedules')->group(function () {

    Route::post('/store', [ScheduleController::class, 'store']);
    Route::get('/index', [ScheduleController::class, 'index']);
    Route::get('/show/{id}', [ScheduleController::class, 'show']);
    Route::put('/update/{id}', [ScheduleController::class, 'update']);
    Route::delete('/destroy/{id}', [ScheduleController::class, 'destroy']);
    Route::get('/filter', [ScheduleController::class, 'filter']);
});

Route::apiResource('classes', ClassController::class);