<?php

use App\Http\Controllers\Sponsoring\BackerOverview;
use App\Livewire\Sponsoring\BackerCreate;
use App\Models\Sponsoring\Contract;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'. Contract::SPONSORING_EDIT_PERMISSION])->group(function () {
//    Route::get('/sponsoring', MemberOverview::class)
//        ->name('sponsoring.index');
    Route::get('/sponsoring/backer', [BackerOverview::class, "index"])
        ->name('sponsoring.backer.index');
    Route::get('/sponsoring/backer/create', BackerCreate::class)
        ->name('sponsoring.backer.create');
//    Route::get('/sponsoring/list/csv', [MemberList::class, 'csv'])
//        ->name('sponsoring.list.csv');
//    Route::get('/sponsoring/list/excel', [MemberList::class, 'excel'])
//        ->name('sponsoring.list.excel');
//    Route::get('/sponsoring/birthdayList/print', [MemberList::class, 'birthdayListPrint'])
//        ->name('sponsoring.birthdayList.print');
//    Route::get('/sponsoring/birthdayList', [MemberList::class, 'birthdayList'])
//        ->name('sponsoring.birthdayList');
});
