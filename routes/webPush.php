<?php

use Illuminate\Support\Facades\Route;


Route::post('/webPush', [\App\Http\Controllers\WebPush::class, 'store'])->name('webPush');

Route::get("/testPush", function() {
    \Illuminate\Support\Facades\Notification::send(\App\Models\WebPushSubscription::all(), new \App\Notifications\UpcomingEvent());
});
