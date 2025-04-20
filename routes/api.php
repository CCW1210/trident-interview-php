<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;

Route::middleware('api')->group(function () {
    // 課程
    Route::get   ('courses',            [CourseController::class, 'index']);
    Route::post  ('courses',            [CourseController::class, 'store']);
    Route::put   ('courses/{courseId}', [CourseController::class, 'update']);
    Route::delete('courses/{courseId}', [CourseController::class, 'destroy']);

    // 講師
    Route::get  ('teachers',                     [TeacherController::class, 'index']);
    Route::post ('teachers',                     [TeacherController::class, 'store']);
    Route::get  ('teachers/{teacherId}/courses', [TeacherController::class, 'courses']);
});
