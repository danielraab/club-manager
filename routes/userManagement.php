<?php

use App\Http\Controllers\UserManagement\UserOverview;
use App\Http\Livewire\UserManagement\UserCreate;
use App\Http\Livewire\UserManagement\UserEdit;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:' . UserPermission::USER_MANAGEMENT_SHOW . '|' . UserPermission::USER_MANAGEMENT_EDIT])->group(function () {
    Route::get('/userManagement', [UserOverview::class, 'index'])
        ->name('userManagement.index');
});
Route::middleware(['auth', 'permission:' . UserPermission::USER_MANAGEMENT_EDIT])->group(function () {
    Route::get('/userManagement/user/create', UserCreate::class)
        ->name('userManagement.create');
    Route::get('/userManagement/user/{user}', UserEdit::class)
        ->name('userManagement.edit');
});
