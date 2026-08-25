<?php

use App\Http\Controllers\Admin\Auth\Authentication;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FilesUpload;
use App\Http\Controllers\VideoStreamController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function (){

//    Route::get('image/{url}', function ($url){
//        $student = Student::where("avatar", $url)->first();
//        dd($student);
//    });

    Route::middleware('guest:admin')->group(function (){
        Route::get('login', [Authentication::class, 'showLogin'])->name('login');
        Route::post('login', [Authentication::class, 'login'])->name('login.submit');
    });
    Route::middleware("auth.admin:admin")->group(function (){
        Route::post('fileUpload', [FilesUpload::class, 'fileUpload'])->name('fileUpload');
        Route::post('removeFileUploaded', [FilesUpload::class, 'removeFileUploaded'])->name('removeFileUploaded');
        Route::get('video/preview', [VideoStreamController::class, 'adminPreview'])->name('video.preview');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::post('notifications/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::get('csrf-token', fn () => response()->json(['token' => csrf_token()]))->name('csrf-token');
        Route::post('logout', [Authentication::class, 'logout'])->name('logout');
        require __DIR__ . '/admin_settings.php';
        require __DIR__ . '/admin_permissionsAndEmployees.php';
        require __DIR__ . '/admin_student.php';
        require __DIR__ . '/admin_website.php';
        require __DIR__ . '/admin_report.php';
        require __DIR__ . '/admin_capacitors.php';
        require __DIR__ . '/admin_exams.php';
    });
});
