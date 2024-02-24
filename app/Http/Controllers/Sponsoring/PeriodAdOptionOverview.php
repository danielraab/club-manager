<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;
use App\Models\Sponsoring\Period;

class PeriodAdOptionOverview extends Controller
{
    public function index(Period $period)
    {
        return view('sponsoring.period-ad-option-overview', [
            "period" => $period
        ]);
    }

}
