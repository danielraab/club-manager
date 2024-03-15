<?php

use App\Http\Controllers\Members\MemberList;
use App\Livewire\Members\BirthdayList;
use App\Livewire\Members\Import\MemberImport;
use App\Livewire\Members\MemberCreate;
use App\Livewire\Members\MemberEdit;
use App\Livewire\Members\MemberGroupCreate;
use App\Livewire\Members\MemberGroupEdit;
use App\Livewire\Members\MemberOverview;
use App\Models\Import\ImportedMember;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'.Member::MEMBER_SHOW_PERMISSION.'|'.Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members', MemberOverview::class)
        ->name('member.index');
    Route::get('/members/list/csv', [MemberList::class, 'csv'])
        ->name('member.list.csv');
    Route::get('/members/list/excel', [MemberList::class, 'excel'])
        ->name('member.list.excel');
    Route::get('/members/birthdayList/print', [MemberList::class, 'birthdayListPrint'])
        ->name('member.birthdayList.print');
    Route::get('/members/birthdayList', BirthdayList::class)
        ->name('member.birthdayList');
});

Route::middleware(['auth', 'permission:'.ImportedMember::MEMBER_IMPORT_PERMISSION])->group(function () {
    Route::get('/members/import', MemberImport::class)
        ->name('member.import');
});

Route::middleware(['auth', 'permission:'.Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members/groups', fn () => view('members.member-group-overview'))
        ->name('member.group.index');
    Route::get('/members/groups/create', MemberGroupCreate::class)
        ->name('member.group.create');
    Route::get('/members/groups/{memberGroup}', MemberGroupEdit::class)
        ->name('member.group.edit');

    Route::get('/members/member/create', MemberCreate::class)
        ->name('member.create');
    Route::get('/members/member/{member}', MemberEdit::class)
        ->name('member.edit');
});
