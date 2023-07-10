<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'newsList' => $this->loadNewsList(),
            'eventList' => $this->loadEventList(),
        ]);
    }

    private function loadNewsList(): Collection
    {
        $newsList = News::orderBy('display_until', 'desc');
        $newsList = $newsList->where('display_until', '>', now());
        $newsList = $newsList->where('enabled', true);
        if (Auth::guest()) {
            $newsList = $newsList->where('logged_in_only', false);
        }

        return $newsList->get();
    }

    private function loadEventList()
    {
        $eventList = Event::getFutureEvents(inclLoggedInOnly: Auth::check());
        $eventList->limit(5);

        return $eventList->get();
    }
}
