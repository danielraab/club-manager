<?php

namespace App\Http\Controllers\InfoMessage;

use App\Http\Controllers\Controller;
use App\Models\InfoMessage;
use Illuminate\Support\Facades\Auth;

class InfoMessageOverview extends Controller
{
    public function index()
    {
        $messages = InfoMessage::orderBy('onDashboardUntil', 'desc');
        if(!Auth::user()->hasPermission(InfoMessage::INFO_MESSAGE_EDIT_PERMISSION)) {
            $messages = $messages->where("enabled", true);
        }
        $messages = $messages->paginate(10);

        return view('info-message.message-overview', [
            'messages' => $messages
        ]);
    }
}
