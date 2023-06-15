<?php

use App\Http\Controllers\UserManagement\MemberOverview;
use App\Http\Livewire\UserManagement\UserCreate;
use App\Http\Livewire\UserManagement\UserEdit;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:'. Member::MEMBER_SHOW_PERMISSION.'|'.Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members', [MemberOverview::class, 'index'])
        ->name('member.index');
});
Route::middleware(['auth', 'permission:'.Member::MEMBER_EDIT_PERMISSION])->group(function () {
    Route::get('/members/groups', fn () => view('members.member-group-overview'))
        ->name('member.group.index');


    //TODO
    Route::get('/members/groups/create', UserCreate::class)
        ->name('member.group.create');
    Route::get('/members/groups/{memberGroup}', UserEdit::class)
        ->name('member.group.edit');
    Route::get('/members/member/create', UserCreate::class)
        ->name('member.create');
    Route::get('/members/member/{member}', UserEdit::class)
        ->name('member.edit');
});
