<?php

use App\Http\Controllers\Admin\permissionsAndEmployees\PermissionController;
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

Route::prefix('permissionsAndEmployees')->name('permissionsAndEmployees.')->group(function (){
    Route::prefix('permission')->name('permission.')->group(function (){
        Route::get('index', [permissionController::class, 'index'])->name('index');
        Route::get('create', function (){ return view('admin.permissionsAndEmployees.permission.create'); })->name('create');
        Route::post('create', [permissionController::class, 'create'])->name('create');
        Route::get('edit/{id}', [permissionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [permissionController::class, 'update'])->name('update');
    });

});


