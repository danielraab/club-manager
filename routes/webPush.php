<?php

use Illuminate\Support\Facades\Route;

Route::get('/webPush/vapidPublicKey', [\App\Http\Controllers\WebPush::class, 'vapidPublicKey'])
    ->name('webPush.vapidPublicKey');
Route::post('/webPush/hasEndpoint', [\App\Http\Controllers\WebPush::class, 'hasEndpoint'])
    ->name('webPush.hasEndpoint');
Route::post('/webPush/removeEndpoint', [\App\Http\Controllers\WebPush::class, 'removeEndpoint'])
    ->name('webPush.removeEndpoint');
Route::post('/webPush', [\App\Http\Controllers\WebPush::class, 'store'])
    ->name('webPush.store');
