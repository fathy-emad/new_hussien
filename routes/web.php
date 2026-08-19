<?php

use App\Http\Controllers\VideoStreamController;
use App\Http\Controllers\Website\Welcome;
use Illuminate\Support\Facades\Route;


Route::get('/video/website/{file}', [VideoStreamController::class, 'website'])
    ->where('file', '[a-zA-Z0-9._\-]+')
    ->name('video.website');
Route::get('/video/capacitor/{id}', [VideoStreamController::class, 'capacitor'])->name('video.capacitor');

Route::get('/', [Welcome::class, 'homepage'])->name('home');
Route::get('/capacitors', [Welcome::class, 'capacitors'])->name('capacitors');
Route::post('/capacitor', [Welcome::class, 'capacitor'])->name('capacitor');
Route::get('/capacitor_lesson', [Welcome::class, 'get_Capacitor'])->name('capacitor_lesson');
Route::get('/contact', [Welcome::class, 'contact'])->name('contact');

Route::post('/website-asks', [Welcome::class, 'website_asks'] )->name('website_asks');

require __DIR__.'/admin.php';
require __DIR__.'/student.php';