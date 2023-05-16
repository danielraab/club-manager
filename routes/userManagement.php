<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:' . \App\Models\UserPermission::USER_MANAGEMENT])->group(function () {
    Route::get('/userManagement', [\App\Http\Controllers\UserManagement\UserOverview::class, "index"])
        ->name('userManagement.index');
    Route::get('/userManagement/user/create', \App\Http\Livewire\UserManagement\UserCreate::class)
        ->name('userManagement.create');
    Route::get('/userManagement/user/{user}', \App\Http\Livewire\UserManagement\UserEdit::class)
        ->name('userManagement.edit');
});
