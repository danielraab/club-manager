<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;

class PackageOverview extends Controller
{
    public function index()
    {
        return view('sponsoring.packages', [
        ]);
    }

}
