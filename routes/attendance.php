<?php

use App\Http\Controllers\Attendance\Display;
use App\Http\Controllers\Attendance\PollOverview;
use App\Http\Livewire\Attendance\Record;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:' . Attendance::ATTENDANCE_SHOW_PERMISSION . '|' . Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance', [Display::class, "index"])
        ->name('event.attendance.show');
});

Route::middleware(['auth', 'permission:' . Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance/edit', Record::class)
        ->name('event.attendance.edit');
});

Route::middleware(['auth', 'permission:' . \App\Models\AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION . '|' . \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION])
    ->group(function () {
        Route::get('/attendancePolls', [PollOverview::class, "index"])
            ->name('attendancePoll.index');
    });


Route::middleware(['auth', 'permission:' . \App\Models\AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION])
    ->group(function () {
        Route::get('/attendancePolls/create', [PollOverview::class, "index"])
            ->name('attendancePoll.create');
    });
