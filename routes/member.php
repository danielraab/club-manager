<?php

use App\Http\Controllers\Members\MemberBirthdayList;
use App\Http\Livewire\Members\Import\MemberImport;
use App\Http\Livewire\Members\MemberCreate;
use App\Http\Livewire\Members\MemberEdit;
use App\Http\Livewire\Members\MemberGroupCreate;
use App\Http\Livewire\Members\MemberGroupEdit;
use App\Http\Livewire\Members\MemberOverview;
use App\Models\Import\ImportedMember;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'.Member::MEMBER_SHOW_PERMISSION.'|'.Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members', MemberOverview::class)
        ->name('member.index');
    Route::get('/members/birthdayList/csv', [MemberBirthdayList::class, 'csv'])
        ->name('member.birthdayList.csv');
    Route::get('/members/fullBirthdayList/csv', [MemberBirthdayList::class, 'fullCsv'])
        ->name('member.fullBirthdayList.csv');
    Route::get('/members/birthdayList', [MemberBirthdayList::class, 'birthdayList'])
        ->name('member.birthdayList');
    Route::get('/members/fullBirthdayList', [MemberBirthdayList::class, 'fullBirthdayList'])
        ->name('member.fullBirthdayList');
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
