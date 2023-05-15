<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/userManagement', function () {
        return view('dashboard');
    })->name('userManagement.index');
});
