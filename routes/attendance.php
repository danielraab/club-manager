<?php

use App\Http\Controllers\Events\EventCalendar;
use App\Http\Livewire\Events\EventCreate;
use App\Http\Livewire\Events\EventEdit;
use App\Http\Livewire\Events\EventOverview;
use App\Http\Livewire\Events\EventTypeCreate;
use App\Http\Livewire\Events\EventTypeEdit;
use App\Models\Attendance;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'. Attendance::ATTENDANCE_SHOW_PERMISSION.'|'.Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance', [])
        ->name('event.attendance.show');
});

Route::middleware(['auth', 'permission:'. Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance/edit', [])
        ->name('event.attendance.edit');
});
