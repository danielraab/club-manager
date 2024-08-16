<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;
use App\Models\Sponsoring\Period;

class PeriodMemberAssignment extends Controller
{
    public function index(Period $period): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $previousPeriod = Period::query()
            ->whereNot('id', $period->id)
            ->where('end', '<', $period->end)
            ->orderBy('end', 'desc')->first();

        return view('sponsoring.period-member-assignment', [
            'period' => $period,
            'previousPeriod' => $previousPeriod,
        ]);
    }
}
