<?php

use App\Http\Livewire\Events\EventOverview;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/events', EventOverview::class)
    ->name('events.index');

Route::middleware(['auth', 'permission:' . Event::EVENT_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/create', null)
        ->name('event.create');
    Route::get('/events/event/{event}', null)
        ->name('event.edit');
});
