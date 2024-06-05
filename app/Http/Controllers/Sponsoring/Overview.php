<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;

class Overview extends Controller
{
    public function index()
    {
        return view('sponsoring.overview', [
        ]);
    }
}
