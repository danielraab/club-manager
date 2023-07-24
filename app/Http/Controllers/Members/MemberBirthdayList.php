<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Response;

class MemberBirthdayList extends Controller
{
    const CSV_SEPARATOR = ',';

    public function streamFullCSV() {
        $this->streamCSV(true);
    }

    public function streamCSV(bool $allMembers = false)
    {
        $file = fopen('php://output', 'w');
        fwrite($file, 'sep=' . self::CSV_SEPARATOR . "\n");
        fputcsv($file, [__('Name'), __('Birthday'), __('Age')], self::CSV_SEPARATOR);

        foreach ($this->getBirthdaySortedMembers($allMembers) as $member) {
            /** @var Member $member */
            fputcsv($file, [
                $member->getFullName(),
                $member->birthday->isoFormat('D. MMMM'),
                now()->format('Y') - $member->birthday->format('Y'),
            ], self::CSV_SEPARATOR);
        }
        fclose($file);
    }

    public function csv()
    {
        return Response::stream([$this, 'streamCSV'], 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="birthdayList.csv"',
        ]);
    }

    public function fullCsv()
    {
        return Response::stream([$this, 'streamFullCSV'], 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="fullBirthdayList.csv"',
        ]);
    }

    private function getBirthdaySortedMembers(bool $allMembers = false): \Illuminate\Database\Eloquent\Collection|array
    {
        return Member::getAllFiltered(!$allMembers, !$allMembers, !$allMembers)->whereNotNull('birthday')->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
            });
    }

    public function fullBirthdayList() {
        return $this->birthdayList(true);
    }

    public function birthdayList(bool $allMembers = false)
    {
        $missingBirthdayList = Member::getAllFiltered(!$allMembers, !$allMembers, !$allMembers)->whereNull('birthday')
            ->orderBy('lastname')->get();
        $memberList = $this->getBirthdaySortedMembers($allMembers);

        return view('members.member-birthday-list', [
                'missingBirthdayList' => $missingBirthdayList,
                'members' => $memberList
            ]
        );
    }
}
