<?php

use App\Http\Controllers\Admin\Students\StudentAttendanceController;
use App\Http\Controllers\Admin\Students\StudentCardsController;
use App\Http\Controllers\Admin\Students\StudentManageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| admin -> system administrator Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin -> system administrator routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('students')->name('students.')->group(function (){
    Route::prefix('studentManage')->name('studentManage.')->group(function (){
        Route::get('view/{id}', [StudentManageController::class, 'view'])->name('view');
        Route::get('index', [StudentManageController::class, 'index'])->name('index');
        Route::get('create', [StudentManageController::class, 'showCreate'])->name('create');
        Route::post('create', [StudentManageController::class, 'create'])->name('create.submit');
        Route::get('edit/{id}', [StudentManageController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [StudentManageController::class, 'update'])->name('update');
        Route::post('delete/{id}', [StudentManageController::class, 'delete'])->name('delete');
    });


    Route::prefix('studentCards')->name('studentCards.')->group(function (){
        Route::get('index', [StudentCardsController::class, 'index'])->name('index');
        Route::post('create', [StudentCardsController::class, 'create'])->name('create');
        Route::get('view/{batch}', [StudentCardsController::class, 'view'])->name('view');
        Route::post('delete/{batch}', [StudentCardsController::class, 'delete'])->name('delete');
        Route::get('download/{batch}', [StudentCardsController::class, 'download'])->name('download');
    });


    Route::prefix('studentAttendance')->name('studentAttendance.')->group(function (){
        Route::get('index', [StudentAttendanceController::class, 'index'])->name('index');
        Route::post('create', [StudentAttendanceController::class, 'create'])->name('create');
    });
});
