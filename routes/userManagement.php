<?php

use App\Http\Controllers\UserManagement\MemberOverview;
use App\Http\Livewire\UserManagement\UserCreate;
use App\Http\Livewire\UserManagement\UserEdit;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'.UserPermission::USER_MANAGEMENT_SHOW_PERMISSION.'|'.UserPermission::USER_MANAGEMENT_EDIT_PERMISSION])->group(function () {
    Route::get('/userManagement', [MemberOverview::class, 'index'])
        ->name('userManagement.index');
});
Route::middleware(['auth', 'permission:'.UserPermission::USER_MANAGEMENT_EDIT_PERMISSION])->group(function () {
    Route::get('/userManagement/user/create', UserCreate::class)
        ->name('userManagement.create');
    Route::get('/userManagement/user/{user}', UserEdit::class)
        ->name('userManagement.edit');
});
