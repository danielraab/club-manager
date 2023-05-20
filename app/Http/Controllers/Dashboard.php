<?php

namespace App\Http\Controllers;

use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $messages = InfoMessage::orderBy('display_until', 'desc');
        $messages = $messages->where("display_until", '>', now());
        $messages = $messages->where("enabled", true);
        if(!Auth::user()) {
            $messages = $messages->where("logged_in_only", false);
        }
        $messages = $messages->get();

        return view('dashboard', [
            'messages' => $messages
        ]);
    }
}
