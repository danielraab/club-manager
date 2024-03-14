<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\Filter\MemberFilter;
use App\Models\Member;
use App\Models\MemberGroup;
use Illuminate\Support\Facades\Response;

class MemberList extends Controller
{
    const CSV_SEPARATOR = ',';

    public function excel(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Response::stream(function () {

            $sheetName = 'memberList';

            $header = [
                __('Name') => 'string',
                __('Birthday date') => 'date',
                __('Birthday') => 'string',
                __('Age') => 'integer',
                __('Email') => 'string',
                __('Phone') => 'string',
            ];
            $writer = new \XLSXWriter();

            $writer->writeSheetHeader($sheetName, $header);
            foreach (\App\Models\Member::getAllFiltered(MemberFilter::getMemberFilterFromRequest())->get() as $member) {
                /** @var Member $member */
                $writer->writeSheetRow($sheetName, [
                    $member->getFullName(),
                    $member->birthday?->format('Y-m-d'),
                    $member->birthday?->isoFormat('D. MMMM'),
                    $member->birthday ? now()->format('Y') - $member->birthday->format('Y') : null,
                    $member->email,
                    $member->phone,
                ]);
            }

            $writer->writeToStdOut();
        }, 200, [
            'Content-Type' => 'text/xlsx',
            'Content-Disposition' => 'attachment; filename="memberList.xlsx"',
        ]);
    }

    public function csv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Response::stream(function () {
            $file = fopen('php://output', 'w');
            fwrite($file, 'sep='.self::CSV_SEPARATOR."\n");
            fputcsv($file, [__('Name'), __('Birthday'), __('Age'), __('Email'), __('Phone')], self::CSV_SEPARATOR);

            foreach (\App\Models\Member::getAllFiltered(MemberFilter::getMemberFilterFromRequest())->get() as $member) {
                /** @var Member $member */
                fputcsv($file, [
                    $member->getFullName(),
                    $member->birthday?->isoFormat('D. MMMM'),
                    $member->birthday ? now()->format('Y') - $member->birthday->format('Y') : null,
                    $member->email,
                    $member->phone,
                ], self::CSV_SEPARATOR);
            }
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="memberList.csv"',
        ]);
    }

    private function getBirthdaySortedMembers(MemberFilter $filer = null): \Illuminate\Database\Eloquent\Collection|array
    {
        return Member::getAllFiltered($filer)->whereNotNull('birthday')->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
            });
    }

    public function birthdayListPrint(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $filer = $this->getFilterFromConfig();
        $missingBirthdayList = Member::getAllFiltered($filer)->whereNull('birthday')
            ->orderBy('lastname')->get();
        $memberList = $this->getBirthdaySortedMembers($filer);

        return view('members.member-birthday-list-print', [
            'missingBirthdayList' => $missingBirthdayList,
            'members' => $memberList,
        ]);
    }

    private function getFilterFromConfig(): MemberFilter
    {
        $filterMemberGroup = null;
        $filterShowPaused = Configuration::getBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_PAUSED, auth()->user(), false);
        $filterShowAfterRetired = Configuration::getBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_AFTER_RETIRED, auth()->user(), false);
        $filterShowBeforeEntrance = Configuration::getBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_BEFORE_ENTRANCE, auth()->user(), false);

        $filterMemberGroupId = Configuration::getInt(
            ConfigurationKey::MEMBER_FILTER_GROUP_ID, auth()->user());
        if ($filterMemberGroupId) {
            $filterMemberGroup = MemberGroup::query()->find($filterMemberGroupId)->first();
        }

        return new MemberFilter($filterShowBeforeEntrance, $filterShowAfterRetired, $filterShowPaused, $filterMemberGroup);
    }

    public function birthdayList(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $filter = $this->getFilterFromConfig();
        $missingBirthdayList = Member::getAllFiltered($filter)
            ->whereNull('birthday')
            ->orderBy('lastname')->get();
        $memberList = $this->getBirthdaySortedMembers($filter);

        return view('members.member-birthday-list', [
            'missingBirthdayList' => $missingBirthdayList,
            'members' => $memberList,
        ]);
    }
}
