<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;

class AdOptionOverview extends Controller
{
    public function index()
    {
        return view('sponsoring.ad-option', [
        ]);
    }
}
