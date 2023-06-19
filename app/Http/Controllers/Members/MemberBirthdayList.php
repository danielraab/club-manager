<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Response;

class MemberBirthdayList extends Controller
{
    const CSV_SEPARATOR = ",";

    public function streamCSV() {
        $file = fopen('php://output', 'w');
        fputs($file,"sep=".self::CSV_SEPARATOR."\n");
        fputcsv($file, [__("Name"), __("Birthday"), __("Age")], self::CSV_SEPARATOR);

        foreach($this->getBirthdaySortedMembers() as $member) {
            fputcsv($file, [
                $member->lastname. " " . $member->firstname,
                $member->birthday->isoFormat("D. MMMM"),
                now()->format("Y") - $member->birthday->format("Y")
            ], self::CSV_SEPARATOR);

        }
        fclose($file);
    }
    public function csv()
    {
        return Response::stream([$this, "streamCSV"], 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="calendar.csv"',
        ]);
    }

    private function getBirthdaySortedMembers(): \Illuminate\Database\Eloquent\Collection|array
    {
        return  Member::allActive()->whereNotNull("birthday")->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat("MM-DD"), $memberB->birthday->isoFormat("MM-DD"));
            });
    }

    public function index()
    {
        $missingBirthdayList = Member::allActive()->whereNull("birthday")
            ->orderBy("lastname")->get();
        $memberList = $this->getBirthdaySortedMembers();

        return view('members.member-birthday-list', [
                'missingBirthdayList' => $missingBirthdayList,
                'members' => $memberList
            ]
        );
    }
}
