<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;

class BackerOverview extends Controller
{
    public function index()
    {
        return view('sponsoring.backer', [
        ]);
    }
}
