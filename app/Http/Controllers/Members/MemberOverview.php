<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberOverview extends Controller
{
    public function index()
    {
        return view('members.member-overview', [
            'members' => Member::orderBy("lastname")->orderBy("firstname")->get()]
        );
    }
}
