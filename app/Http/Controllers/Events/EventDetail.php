<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class EventDetail extends Controller
{
    public function index(Event $event): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        /** @var ?User $user */
        $user = auth()->user();

        if ($user && $event->member_group_id &&
            ! Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION)) {

            $userGroups = $user->getMember()?->memberGroups()?->pluck('id')->toArray() ?: [];
            if (! in_array($event->member_group_id, $userGroups)) {
                throw new ModelNotFoundException();
            }
        }

        if ($user === null && (! $event->enabled || $event->memberGroup)) {
            throw new ModelNotFoundException();
        }

        return view('events.event-detail', ['event' => $event]);
    }
}
