<?php

namespace App\Http\Controllers\InfoMessage;

use App\Http\Controllers\Controller;
use App\Models\InfoMessage;

class InfoMessageOverview extends Controller
{
    public function index()
    {
        return view('infoMessage.messageOverview', ['messages' => InfoMessage::orderBy('onDashboardUntil', 'desc')->paginate(10)]);
    }
}
