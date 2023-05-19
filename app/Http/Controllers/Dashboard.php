<?php

namespace App\Http\Controllers;

use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $messages = InfoMessage::orderBy('onDashboardUntil', 'desc');
        $messages = $messages->where("onDashboardUntil", '>', now());
        $messages = $messages->where("enabled", true);
        if(!Auth::user()) {
            $messages = $messages->where("onlyInternal", false);
        }
        $messages = $messages->get();

        return view('dashboard', [
            'messages' => $messages
        ]);
    }
}
