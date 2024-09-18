<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Filter\MemberFilter;
use App\Models\Member;
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
            $writer = new \XLSXWriter;

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

    public function birthdayListPrint(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $printMissing = request()->has('printMissing');
        $missingBirthdayList = [];

        $filter = MemberFilter::getMemberFilterFromConfig();
        if ($printMissing) {
            $missingBirthdayList = Member::getAllFiltered($filter)->whereNull('birthday')
                ->orderBy('lastname')->get();
        }
        $memberList = Member::getAllFiltered($filter)->whereNotNull('birthday')->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
            });

        return view('members.member-birthday-list-print', [
            'missingBirthdayList' => $missingBirthdayList,
            'members' => $memberList,
        ]);
    }
}
