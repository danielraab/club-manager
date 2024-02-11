<?php

use App\Http\Controllers\Sponsoring\AdOptionOverview;
use App\Http\Controllers\Sponsoring\BackerOverview;
use App\Http\Controllers\Sponsoring\Overview;
use App\Livewire\Sponsoring\AdOptionCreate;
use App\Livewire\Sponsoring\BackerCreate;
use App\Livewire\Sponsoring\BackerEdit;
use App\Models\Sponsoring\Contract;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'.Contract::SPONSORING_SHOW_PERMISSION.'|'.Contract::SPONSORING_EDIT_PERMISSION])->group(function () {
    Route::get('/sponsoring', [Overview::class, "index"])
        ->name('sponsoring.index');
    Route::get('/sponsoring/backer', [BackerOverview::class, "index"])
        ->name('sponsoring.backer.index');
    Route::get('/sponsoring/adOption', [AdOptionOverview::class, "index"])
        ->name('sponsoring.ad-option.index');
});

Route::middleware(['auth', 'permission:'. Contract::SPONSORING_EDIT_PERMISSION])->group(function () {
    Route::get('/sponsoring/backer/create', BackerCreate::class)
        ->name('sponsoring.backer.create');
    Route::get('/sponsoring/backer/{backer}', BackerEdit::class)
        ->name('sponsoring.backer.edit');

    Route::get('/sponsoring/adOption/create', AdOptionCreate::class)
        ->name('sponsoring.ad-option.create');
    Route::get('/sponsoring/adOption/{adOption}', null)
        ->name('sponsoring.ad-option.edit');



//    Route::get('/sponsoring/list/csv', [MemberList::class, 'csv'])
//        ->name('sponsoring.list.csv');
//    Route::get('/sponsoring/list/excel', [MemberList::class, 'excel'])
//        ->name('sponsoring.list.excel');
//    Route::get('/sponsoring/birthdayList/print', [MemberList::class, 'birthdayListPrint'])
//        ->name('sponsoring.birthdayList.print');
//    Route::get('/sponsoring/birthdayList', [MemberList::class, 'birthdayList'])
//        ->name('sponsoring.birthdayList');
});
