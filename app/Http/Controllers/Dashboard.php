<?php

namespace App\Http\Controllers;

use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $messages = InfoMessage::orderBy('on_dashboard_until', 'desc');
        $messages = $messages->where("on_dashboard_until", '>', now());
        $messages = $messages->where("enabled", true);
        if(!Auth::user()) {
            $messages = $messages->where("only_internal", false);
        }
        $messages = $messages->get();

        return view('dashboard', [
            'messages' => $messages
        ]);
    }
}
