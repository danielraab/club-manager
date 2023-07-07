<?php

use App\Http\Controllers\Attendance\Display;
use App\Http\Livewire\Attendance\Record;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'. Attendance::ATTENDANCE_SHOW_PERMISSION.'|'.Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance', [Display::class, "index"])
        ->name('event.attendance.show');
});

Route::middleware(['auth', 'permission:'. Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance/edit', Record::class)
        ->name('event.attendance.edit');
});
