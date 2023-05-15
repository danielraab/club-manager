<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth','permission:'.\App\Models\UserPermission::USER_MANAGEMENT])->group(function () {
    Route::get('/userManagement', function () {
        return view('dashboard');
    })->name('userManagement.index');
});
