<?php

use App\Http\Controllers\News\NewsOverview;
use App\Livewire\News\NewsCreate;
use App\Livewire\News\NewsEdit;
use App\Models\News;
use Illuminate\Support\Facades\Route;

Route::get('/news/{news}/detail', [\App\Http\Controllers\News\NewsDetail::class, "index"])
    ->name('news.detail');

Route::middleware(['auth'])->group(function () {
    Route::get('/news', [NewsOverview::class, 'index'])
        ->name('news.index');

});
Route::middleware(['auth', 'permission:' . News::NEWS_EDIT_PERMISSION])->group(function () {
    Route::get('/news/news/create', NewsCreate::class)
        ->name('news.create');
    Route::get('/news/news/{news}', NewsEdit::class)
        ->name('news.edit');
});
