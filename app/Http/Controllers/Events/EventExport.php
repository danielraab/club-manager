<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventExport extends Controller
{
    public function toJson(): string
    {
        return $this->getEventList(! auth()->guest())->toJson();
    }

    private function getEventList($inclLoggedInOnly = false): Collection
    {
        $eventList = \App\Models\Event::query()->orderBy('start', 'desc');
        if (! $inclLoggedInOnly) {
            $eventList = $eventList->where('logged_in_only', false);
        }
        $eventList = $eventList->where('enabled', true);

        return $eventList->get(['id', 'title', 'description', 'whole_day', 'start', 'end', 'link', 'location', 'dress_code']);
    }

    public function next(Request $request)
    {
        if (validator($request->query(), ['limit' => ['nullable', 'int']])->fails()) {
            abort(400);
        }

        $eventList = \App\Models\Event::orderBy('start', 'asc');
        if (Auth::guest()) {
            $eventList = $eventList->where('logged_in_only', false);
        }
        $eventList = $eventList->where('enabled', true)->where('end', '>', now());
        if ($limit = $request->query('limit')) {
            $eventList = $eventList->limit($limit);
        }

        return $eventList->get(['id', 'title', 'description', 'whole_day', 'start', 'end', 'link', 'location', 'dress_code']);
    }
}
