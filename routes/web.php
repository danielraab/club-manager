<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\UploadedFileController;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Dashboard::class, 'index'])->name('home');
Route::get('/file/{file}', [UploadedFileController::class, 'response'])->name('file');
Route::get('/file/{file}/download', [UploadedFileController::class, 'download'])->name('file.download');
Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:'. UserPermission::ADMIN_USER_PERMISSION])->group(function () {
    Route::get('/settings', [Settings::class, 'index'])->name('settings');
});

require __DIR__.'/webPush.php';
require __DIR__.'/auth.php';
require __DIR__.'/userManagement.php';
require __DIR__.'/news.php';
require __DIR__.'/event.php';
require __DIR__.'/member.php';
require __DIR__.'/sponsoring.php';
