<?php

use App\Http\Controllers\Admin\Exams\ExamController;
use App\Http\Controllers\Admin\Exams\QuestionController;
use App\Http\Controllers\Admin\Exams\ResultController;
use Illuminate\Support\Facades\Route;

Route::prefix('exams')->name('exams.')->group(function () {
    Route::prefix('question')->name('question.')->controller(QuestionController::class)->group(function () {
        Route::get('view/{id}', 'view')->name('view');
        Route::get('index', 'index')->name('index');
        Route::get('create', 'showCreate')->name('create');
        Route::post('create', 'create')->name('create.submit');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('exam')->name('exam.')->controller(ExamController::class)->group(function () {
        Route::get('view/{id}', 'view')->name('view');
        Route::get('index', 'index')->name('index');
        Route::get('create', 'showCreate')->name('create');
        Route::post('create', 'create')->name('create.submit');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('result')->name('result.')->controller(ResultController::class)->group(function () {
        Route::get('view/{id}', 'view')->name('view');
        Route::get('index', 'index')->name('index');
        Route::post('delete/{id}', 'delete')->name('delete');
    });
});
