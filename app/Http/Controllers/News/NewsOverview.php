<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class NewsOverview extends Controller
{
    public function index()
    {
        $newsList = News::orderBy('display_until', 'desc');
        if (! Auth::user()->hasPermission(News::NEWS_EDIT_PERMISSION)) {
            $newsList = $newsList->where('enabled', true);
        }
        $newsList = $newsList->paginate(10);

        return view('news.news-overview', [
            'newsList' => $newsList,
        ]);
    }
}
