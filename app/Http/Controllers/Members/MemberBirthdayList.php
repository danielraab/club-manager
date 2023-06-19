<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberBirthdayList extends Controller
{
    public function index()
    {
        return view('members.member-birthday-list', [
            'members' => Member::orderBy("birthday")->orderBy("lastname")->get()]
        );
    }
}
