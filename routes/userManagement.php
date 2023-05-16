<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'permission:' . \App\Models\UserPermission::USER_MANAGEMENT])->group(function () {
    Route::get('/userManagement', [\App\Http\Controllers\UserManagement\UserOverview::class, "index"])
        ->name('userManagement.index');
});
