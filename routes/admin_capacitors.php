<?php

use App\Http\Controllers\Admin\Capacitors\CapacitorController;
use App\Http\Controllers\Admin\Capacitors\CardController;
use Illuminate\Support\Facades\Route;

Route::prefix('capacitors')->name('capacitors.')->group(function () {
    Route::prefix('capacitor')->name('capacitor.')->group(function () {
        Route::get('view/{id}', [CapacitorController::class, 'view'])->name('view');
        Route::get('index', [CapacitorController::class, 'index'])->name('index');
        Route::get('create', [CapacitorController::class, 'showCreate'])->name('create');
        Route::post('create', [CapacitorController::class, 'create'])->name('create.submit');
        Route::get('edit/{id}', [CapacitorController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CapacitorController::class, 'update'])->name('update');
        Route::post('delete/{id}', [CapacitorController::class, 'delete'])->name('delete');
    });

    Route::prefix('card')->name('card.')->group(function () {
        Route::get('view/{batch}', [CardController::class, 'view'])->name('view');
        Route::get('index', [CardController::class, 'index'])->name('index');
        Route::post('create', [CardController::class, 'create'])->name('create');
        Route::post('delete/{batch}', [CardController::class, 'delete'])->name('delete');
    });
});
