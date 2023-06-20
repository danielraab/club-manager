<?php

use App\Http\Controllers\Members\MemberBirthdayList;
use App\Http\Controllers\Members\MemberOverview;
use App\Http\Livewire\Members\MemberCreate;
use App\Http\Livewire\Members\MemberGroupCreate;
use App\Http\Livewire\Members\MemberGroupEdit;
use App\Http\Livewire\UserManagement\UserEdit;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:' . Member::MEMBER_SHOW_PERMISSION . '|' . Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members', [MemberOverview::class, 'index'])
        ->name('member.index');
    Route::get('/members/birthdayList/csv', [MemberBirthdayList::class, 'csv'])
        ->name('member.birthdayList.csv');
    Route::get('/members/birthdayList', [MemberBirthdayList::class, 'index'])
        ->name('member.birthdayList');
});

Route::middleware(['auth', 'permission:' . Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members/groups', fn() => view('members.member-group-overview'))
        ->name('member.group.index');
    Route::get('/members/groups/create', MemberGroupCreate::class)
        ->name('member.group.create');
    Route::get('/members/groups/{memberGroup}', MemberGroupEdit::class)
        ->name('member.group.edit');

    Route::get('/members/member/create', MemberCreate::class)
        ->name('member.create');


    //TODO
    Route::get('/members/member/{member}', UserEdit::class)
        ->name('member.edit');
});
