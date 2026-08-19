<?php

use App\Http\Controllers\Admin\Reports\StudentReportsController;
use Illuminate\Support\Facades\Route;

Route::prefix('report')->name('report.')->group(function (){
    Route::prefix('students')->name('students.')->group(function (){
        Route::get('getCounts', [StudentReportsController::class, 'getCounts'])->name('getCounts');
        Route::post('count/edit/{id}', [StudentReportsController::class, 'editCount'])->name('editCount');
    });
});
