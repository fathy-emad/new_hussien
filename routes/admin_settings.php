<?php

use App\Http\Controllers\Admin\Settings\CenterController;
use App\Http\Controllers\Admin\Settings\ChapterController;
use App\Http\Controllers\Admin\Settings\LessonController;
use App\Http\Controllers\Admin\Settings\ScheduleController;
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

Route::prefix('settings')->name('settings.')->group(function (){
    Route::prefix('center')->name('center.')->group(function (){
        Route::get('index', [CenterController::class, 'index'])->name('index');
        Route::get('create', [CenterController::class, 'showCreate'])->name('create');
        Route::post('create', [CenterController::class, 'create'])->name('create.submit');
        Route::get('edit/{id}', [CenterController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CenterController::class, 'update'])->name('update');
        Route::post('delete/{id}', [CenterController::class, 'delete'])->name('delete');
    });
    Route::prefix('chapter')->name('chapter.')->group(function (){
        Route::get('index', [ChapterController::class, 'index'])->name('index');
        Route::get('create', [ChapterController::class, 'showCreate'])->name('create');
        Route::post('create', [ChapterController::class, 'create'])->name('create.submit');
        Route::get('edit/{id}', [ChapterController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ChapterController::class, 'update'])->name('update');
        Route::post('delete/{id}', [ChapterController::class, 'delete'])->name('delete');
    });
    Route::prefix('lesson')->name('lesson.')->group(function (){
        Route::get('view/{id}', [LessonController::class, 'view'])->name('view');
        Route::get('index', [LessonController::class, 'index'])->name('index');
        Route::get('create', [LessonController::class, 'showCreate'])->name('create');
        Route::post('create', [LessonController::class, 'create'])->name('create.submit');
        Route::get('edit/{id}', [LessonController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [LessonController::class, 'update'])->name('update');
        Route::post('delete/{id}', [LessonController::class, 'delete'])->name('delete');
        Route::post('resetViews/{chapter_id}', [LessonController::class, 'resetViews'])->name('resetViews');
    });

    Route::prefix('schedule')->name('schedule.')->group(function (){
        Route::get('index', [ScheduleController::class, 'index'])->name('index');
        Route::get('create', function (){ return view('admin.settings.schedule.create'); })->name('create');
        Route::post('create', [ScheduleController::class, 'create'])->name('create');
        Route::get('edit/{id}', [ScheduleController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ScheduleController::class, 'update'])->name('update');
        Route::post('delete/{id}', [ScheduleController::class, 'delete'])->name('delete');
    });
});


