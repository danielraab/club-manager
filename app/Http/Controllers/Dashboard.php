<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $newsList = News::orderBy('display_until', 'desc');
        $newsList = $newsList->where("display_until", '>', now());
        $newsList = $newsList->where("enabled", true);
        if(!Auth::user()) {
            $newsList = $newsList->where("logged_in_only", false);
        }
        $newsList = $newsList->get();

        return view('dashboard', [
            'newsList' => $newsList
        ]);
    }
}
