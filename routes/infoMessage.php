<?php

use App\Http\Controllers\InfoMessage\InfoMessageOverview;
use App\Http\Livewire\InfoMessage\MessageCreate;
use App\Http\Livewire\InfoMessage\MessageEdit;
use App\Models\InfoMessage;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/infoMessage', [InfoMessageOverview::class, 'index'])
        ->name('infoMessage.index');
});
Route::middleware(['auth', 'permission:' . InfoMessage::INFO_MESSAGE_EDIT_PERMISSION])->group(function () {
    Route::get('/infoMessage/message/create', MessageCreate::class )
        ->name('infoMessage.create');
    Route::get('/infoMessage/message/{message}', MessageEdit::class)
        ->name('infoMessage.edit');
});
