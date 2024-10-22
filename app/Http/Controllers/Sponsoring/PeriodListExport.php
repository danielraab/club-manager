<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Illuminate\Support\Facades\Response;

class PeriodListExport extends Controller
{
    const CSV_SEPARATOR = ',';

    public function csv(Period $period): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Response::stream(function () use ($period) {
            $yes = __('yes');
            $no = __('no');
            $file = fopen('php://output', 'w');
            fwrite($file, 'sep='.self::CSV_SEPARATOR."\n");
            fputcsv($file, [__('Period').':', $period->title]);
            fputcsv($file, [
                __('start').':', $period->start,
                __('end').':', $period->end,
            ]);
            fputcsv($file, [
                __('Backer name'),
                __('Backer city'),
                __('Last period'),
                __('Last member'),
                __('Last package'),
                __('Last amount'),
                __('current member'),
                __('current package'),
                __('current package price'),
                __('contract received'),
                __('ad data received'),
                __('paid'),
            ], self::CSV_SEPARATOR);

            foreach (Backer::query()->with('contracts')->orderBy('name')->get() as $backer) {
                /** @var Backer $backer */
                /** @var Contract $currentContract */
                $currentContract = $backer->contracts()->where('period_id', $period->id)->first();
                if ((! $backer->enabled || $backer->closed_at)
                    && ! $currentContract) {
                    continue;
                }

                /** @var Contract|null $lastContract */
                $lastContract = $backer->contracts()
                    ->whereNot('period_id', $period->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                fputcsv($file, [
                    $backer->name,
                    $backer->city,
                    $lastContract?->period->title ?? '-',
                    $lastContract?->member?->getFullName() ?? '-',
                    $lastContract?->package?->title ?? '-',
                    $lastContract?->package?->price ?? '-',
                    $currentContract?->member?->getFullName() ?? '-',
                    $currentContract?->package?->title ?? '-',
                    $currentContract?->package?->price ?? '-',
                    $currentContract?->contract_received ?? '-',
                    $currentContract?->ad_data_received ?? '-',
                    $currentContract?->paid ?? '-',
                ], self::CSV_SEPARATOR);
            }
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$period->title.'.csv"',
        ]);
    }
}
