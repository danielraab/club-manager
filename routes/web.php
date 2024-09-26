<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings;
use App\Livewire\Development;
use App\Livewire\UploadedFileEdit;
use App\Livewire\UploadedFiles;
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
Route::get('/file/{file}', [FileController::class, 'response'])->name('file');
Route::get('/file/{file}/download', [FileController::class, 'download'])->name('file.download');
Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/imprint', fn () => view('imprint'))->name('imprint');
Route::get('/privacy-policy', fn () => view('privacy-policy'))->name('privacy-policy');

Route::middleware(\App\Http\Middleware\Development::class)->group(function () {
    Route::get('/development', Development::class)->name('development');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:'.UserPermission::ADMIN_USER_PERMISSION])->group(function () {
    Route::get('/settings', [Settings::class, 'index'])->name('settings');
    Route::get('/uploaded-files', UploadedFiles::class)->name('uploaded-file.list');
    Route::get('/uploaded-files/{uploadedFile}', UploadedFileEdit::class)->name('uploaded-file.edit');
});

require __DIR__.'/webPush.php';
require __DIR__.'/auth.php';
require __DIR__.'/userManagement.php';
require __DIR__.'/news.php';
require __DIR__.'/event.php';
require __DIR__.'/member.php';
require __DIR__.'/sponsoring.php';
