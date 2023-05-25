<?php

use App\Http\Livewire\Events\EventCreate;
use App\Http\Livewire\Events\EventOverview;
use App\Http\Livewire\Events\EventTypeCreate;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/events', EventOverview::class)
    ->name('events.index');

Route::middleware(['auth', 'permission:' . Event::EVENT_EDIT_PERMISSION])->group(function () {
    Route::get('/events/event/create', EventCreate::class)
        ->name('event.create');
    Route::get('/events/event/{event}', fn() => "TODO")
        ->name('event.edit');

    Route::get("/events/types", fn() => view("events.event-type-overview"))
        ->name("event.type.index");
    Route::get("/events/types/create", EventTypeCreate::class)
        ->name("event.type.create");
    Route::get("/events/types/{type}", fn() => "TODO")
        ->name("event.type.edit");
});
