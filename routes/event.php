<?php

use App\Http\Controllers\Events\EventCalendar;
use App\Http\Controllers\Events\EventDetail;
use App\Http\Controllers\Events\EventExport;
use App\Http\Controllers\Events\EventICalExport;
use App\Livewire\Events\EventCreate;
use App\Livewire\Events\EventEdit;
use App\Livewire\Events\EventOverview;
use App\Livewire\Events\EventTypeCreate;
use App\Livewire\Events\EventTypeEdit;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/events', EventOverview::class)
    ->name('event.index');

Route::get('/events/{event}/detail', [EventDetail::class, 'index'])
    ->name('event.detail');

Route::get('/events/calendar', [EventCalendar::class, 'render'])
    ->name('event.calendar');
Route::get('/events/ics', [EventICalExport::class, 'iCalendar'])
    ->name('event.iCalendar');
Route::get('/events/json', [EventExport::class, 'toJson'])
    ->name('event.json');
Route::get('/events/next', [EventExport::class, 'next'])
    ->name('event.next');

Route::middleware(['auth', 'permission:'.Event::EVENT_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/create', EventCreate::class)
        ->name('event.create');
    Route::get('/events/event/{event}', EventEdit::class)
        ->name('event.edit');

    Route::get('/events/types', fn () => view('events.event-type-overview'))
        ->name('event.type.index');
    Route::get('/events/types/create', EventTypeCreate::class)
        ->name('event.type.create');
    Route::get('/events/types/{eventType}', EventTypeEdit::class)
        ->name('event.type.edit');
});

require __DIR__.'/attendance.php';
