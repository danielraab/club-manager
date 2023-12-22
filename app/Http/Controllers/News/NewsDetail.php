<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsDetail extends Controller
{
    public function index(News $news)
    {
        if (auth()->guest() &&
            (! $news->enabled || $news->logged_in_only)) {
            throw new ModelNotFoundException();
        }

        return view('news.news-detail', ['news' => $news]);
    }
}
