<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;

class PollOverview extends Controller
{

    public function index()
    {
        return view('attendance.pollOverview', [] );
    }
}
