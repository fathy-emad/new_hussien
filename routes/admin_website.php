<?php

use App\Http\Controllers\Admin\Website\PageController;
use App\Http\Controllers\Admin\Website\RequestsController;
use App\Http\Controllers\Admin\Website\ReviewsController;
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

Route::prefix('website')->name('website.')->group(function () {
    Route::prefix('page')->name('page.')->controller(PageController::class)->group(function () {
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('reviews')->name('reviews.')->controller(ReviewsController::class)->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('approve/{id}', 'approve')->name('approve');
        Route::post('reject/{id}', 'reject')->name('reject');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('requests')->name('requests.')->controller(RequestsController::class)->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('view/{id}', 'view')->name('view');
        Route::post('toggle-read/{id}', 'toggleRead')->name('toggle-read');
        Route::post('delete/{id}', 'delete')->name('delete');
    });
});
