<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;

class PeriodOverview extends Controller
{
    public function index()
    {
        return view('sponsoring.periods', [
        ]);
    }
}
