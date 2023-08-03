<?php

use Illuminate\Support\Facades\Route;


Route::post('/webPush/hasEndpoint', [\App\Http\Controllers\WebPush::class, 'hasEndpoint'])->name('webPush.hasEndpoint');
Route::post('/webPush/removeEndpoint', [\App\Http\Controllers\WebPush::class, 'removeEndpoint'])->name('webPush.hasEndpoint');
Route::post('/webPush', [\App\Http\Controllers\WebPush::class, 'store'])->name('webPush.store');

Route::get("/testPush", function() {
    \Illuminate\Support\Facades\Notification::send(\App\Models\WebPushSubscription::all(), new \App\Notifications\UpcomingEvent());
});
