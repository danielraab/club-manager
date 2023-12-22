<?php

use App\Livewire\Attendance\AttendanceDisplay;
use App\Livewire\Attendance\AttendanceRecord;
use App\Livewire\Attendance\PollCreate;
use App\Livewire\Attendance\PollEdit;
use App\Livewire\Attendance\PollPublic;
use App\Models\Attendance;
use App\Models\AttendancePoll;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'.Attendance::ATTENDANCE_SHOW_PERMISSION.'|'.Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance', AttendanceDisplay::class)
        ->name('event.attendance.show');
});

Route::middleware(['auth', 'permission:'.Attendance::ATTENDANCE_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/{event}/attendance/edit', AttendanceRecord::class)
        ->name('event.attendance.edit');
});

Route::get('/attendancePolls/{attendancePoll}/public', PollPublic::class)
    ->name('attendancePoll.public');

Route::middleware(['auth', 'permission:'.AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION.'|'.AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION])
    ->group(function () {
        Route::get('/attendancePolls', fn () => view('attendance.poll-list'))
            ->name('attendancePoll.index');
        Route::get(
            '/attendancePolls/{attendancePoll}/index',
            fn (AttendancePoll $attendancePoll) => view('attendance.poll-statistic', ['attendancePoll' => $attendancePoll])
        )->name('attendancePoll.statistic');
    });

Route::middleware(['auth', 'permission:'.AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION])->group(function () {
    Route::get('/attendancePolls/create', PollCreate::class)
        ->name('attendancePoll.create');
    Route::get('/attendancePolls/{attendancePoll}/edit', PollEdit::class)
        ->name('attendancePoll.edit');
});
