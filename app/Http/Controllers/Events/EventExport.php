<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Filter\EventFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class EventExport extends Controller
{
    public function toJson(): Collection
    {
        return self::getLimitedAttributes(Event::getAllFiltered(self::getEventFilter()));
    }

    private static function getEventFilter(): EventFilter
    {
        /** @var ?User $user */
        $user = auth()->user();

        $eventFilter = new EventFilter;
        $eventFilter->memberGroups = $user?->getPermittedMemberGroups() ?: [];

        return $eventFilter;
    }

    private static function getLimitedAttributes(Builder $query): Collection
    {
        return $query->get(['id', 'title', 'description', 'whole_day', 'start', 'end', 'link', 'location', 'dress_code']);
    }

    public function next(Request $request): Collection
    {
        if (validator($request->query(), ['limit' => ['nullable', 'int']])->fails()) {
            abort(400);
        }

        $eventFilter = self::getEventFilter();
        $eventFilter->start = now();

        $query = Event::getAllFiltered($eventFilter);

        if ($limit = $request->query('limit')) {
            $query->limit($limit);
        }

        return self::getLimitedAttributes($query);
    }
}
