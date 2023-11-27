<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Livewire\Profile\CalendarLinks;
use App\Models\Member;
use App\Models\MemberFilter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class EventICalExport extends Controller
{
    const CALENDAR_REFRESH_INTERVAL_MIN = 60 * 6;

    public function iCalendar(): \Illuminate\Http\Response
    {
        $calendar = Calendar::create(env('APP_NAME'))->refreshInterval(self::CALENDAR_REFRESH_INTERVAL_MIN);

        $authToken = $this->getPersonalAccessToken();

        if ($authToken && $this->hasMemberShowPermission($authToken)) {
            $this->addMembersToCalendar($calendar);
        }

        $this->addEventsToCalendar($calendar, auth()->user() || $authToken);

        return Response::make($calendar->get(), 200, [
            'Content-Type' => 'text/ics',
            'Content-Disposition' => 'attachment; filename="calendar.ics"',
        ]);
    }

    private function getPersonalAccessToken(): ?PersonalAccessToken
    {
        $token = request()->get("t");

        if ($token) {
            /** @var PersonalAccessToken $pat */
            $pat = PersonalAccessToken::query()
                ->where("token", $token)
                ->where("name", CalendarLinks::CALENDAR_TOKEN_NAME)
                ->first();

            return $pat;
        }
        return null;
    }

    private function hasMemberShowPermission(PersonalAccessToken $pat): bool
    {
        /** @var User $user */
        $user = $pat->tokenable()->first();

        return $user?->hasPermission(Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION) ?: false;
    }


    private function addMembersToCalendar(Calendar $calendar): void
    {
        $currentYear = Carbon::now()->year;

        foreach ($this->getBirthdaySortedMembers() as $member) {
            /** @var $member Member */

            /** @var Carbon $birthday */
            $birthday = $member->birthday->clone();
            $birthday->setYear($currentYear);

            $calEvent = Event::create($member->getFullName());
            $calEvent->startsAt($birthday);
            $calEvent->description((string)($currentYear - $member->birthday->year));
            $calEvent->fullDay();

            $calendar->event($calEvent);
        }
    }

    private function getBirthdaySortedMembers(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Member::getAllFiltered(new MemberFilter(true, true, true))
            ->whereNotNull('birthday')
            ->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
            });
    }

    private function addEventsToCalendar(Calendar $calendar, $inclLoggedInOnly = false): void
    {
        foreach ($this->getEventList($inclLoggedInOnly) as $event) {
            /** @var Carbon $end */
            $calEvent = Event::create($event->title)
                ->startsAt($event->start);
            $end = $event->end;
            if ($event->description) {
                $calEvent->description($event->description);
            }
            if ($event->location) {
                $calEvent->address($event->location);
            }
            if ($event->whole_day) {
                $calEvent->fullDay();
                $end->addDay();
            }
            $calEvent->endsAt($end);
            $calendar->event($calEvent);
        }
    }

    private function getEventList($inclLoggedInOnly = false): Collection
    {
        $eventList = \App\Models\Event::query()->orderBy('start', 'desc');
        if (!$inclLoggedInOnly) {
            $eventList = $eventList->where('logged_in_only', false);
        }
        $eventList = $eventList->where('enabled', true);

        return $eventList->get(['id', 'title', 'description', 'whole_day', 'start', 'end', 'link', 'location', 'dress_code']);
    }
}
