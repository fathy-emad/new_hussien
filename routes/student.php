<?php

use App\Http\Controllers\FilesUpload;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\Auth\Authentication;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ExamController;
use App\Http\Controllers\Student\MaterialController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\ReviewController;
use App\Http\Controllers\VideoStreamController;
use Illuminate\Support\Facades\Route;

Route::prefix('student')->name('student.')->group(function () {
    Route::middleware('guest:student')->group(function () {
        Route::get('login', [Authentication::class, 'showLogin'])->name('login');
        Route::post('login', [Authentication::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth.student:student')->group(function () {
        Route::post('fileUpload', [FilesUpload::class, 'fileUpload'])->name('fileUpload');
        Route::post('removeFileUploaded', [FilesUpload::class, 'removeFileUploaded'])->name('removeFileUploaded');
        Route::post('logout', [Authentication::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [ProfileController::class, 'myProfile'])->name('myProfile');
        Route::post('updateProfile/{id}', [ProfileController::class, 'updateProfile'])->name('updateProfile');

        Route::get('material', [MaterialController::class, 'material'])->name('material');
        Route::get('lesson/{id}', [MaterialController::class, 'lesson'])->name('lesson');
        Route::get('video/lesson/{id}', [VideoStreamController::class, 'lesson'])->name('video.lesson');

        Route::get('exams', [ExamController::class, 'exams'])->name('exams');
        Route::get('exam/open/{exam_id}', [ExamController::class, 'examOpen'])->name('exam.open');
        Route::post('exam/submit', [ExamController::class, 'examSubmit'])->name('exam.submit');

        Route::get('attendance/{month?}', [AttendanceController::class, 'attendance'])->name('attendance');

        Route::get('review', [ReviewController::class, 'create'])->name('review');
        Route::post('review', [ReviewController::class, 'store'])->name('review.submit');
    });
});
