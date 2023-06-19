<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberBirthdayList extends Controller
{
    public function index()
    {
        $missingBirthdayList = Member::allActive()->whereNull("birthday")
            ->orderBy("lastname")->orderBy("firstname")->get();
        $memberList = Member::allActive()->whereNotNull("birthday")->orderBy("lastname")->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat("MM-DD"), $memberB->birthday->isoFormat("MM-DD"));
            });
        return view('members.member-birthday-list', [
                'missingBirthdayList' => $missingBirthdayList,
                'members' => $memberList
            ]
        );
    }
}
