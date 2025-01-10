<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Livewire\Profile\CalendarLinks;
use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\Filter\EventFilter;
use App\Models\Filter\MemberFilter;
use App\Models\Member;
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

        /** @var ?User $user */
        $user = auth()->user();

        if (! $user) {
            $authToken = $this->getPersonalAccessToken();
            $user = $authToken?->tokenable()->first();
        }

        if (Configuration::getBool(ConfigurationKey::EVENT_BIRTHDAYS_IN_ICS_EXPORT) ||
            $user?->hasPermission(Member::MEMBER_SHOW_PERMISSION, Member::MEMBER_EDIT_PERMISSION)) {
            $this->addMembersToCalendar($calendar);
        }

        $memberGroups = $user?->getPermittedMemberGroups() ?: [];

        $this->addEventsToCalendar($calendar, $memberGroups);

        return Response::make($calendar->get(), 200, [
            'Content-Type' => 'text/ics',
            'Content-Disposition' => 'attachment; filename="calendar.ics"',
        ]);
    }

    private function getPersonalAccessToken(): ?PersonalAccessToken
    {
        $token = request()->get('t');

        if ($token) {
            /** @var PersonalAccessToken $pat */
            $pat = PersonalAccessToken::query()
                ->where('token', $token)
                ->where('name', CalendarLinks::CALENDAR_TOKEN_NAME)
                ->first();

            return $pat;
        }

        return null;
    }

    private function addMembersToCalendar(Calendar $calendar): void
    {
        $currentYear = Carbon::now()->year;

        foreach ($this->getBirthdaySortedMembers() as $member) {
            /** @var $member Member */

            /** @var Carbon $birthday */
            $birthdayLastYear = $member->birthday->clone();
            $birthdayLastYear->setYear($currentYear - 1);

            //last year birthday
            $calEvent = Event::create($member->getFullName());
            $calEvent->startsAt($birthdayLastYear);
            $calEvent->description((string) ($currentYear - 1 - $member->birthday->year));
            $calEvent->fullDay();
            $calendar->event($calEvent);

            //this year
            $birthday = $member->birthday->clone();
            $birthday->setYear($currentYear);
            $calEvent = Event::create($member->getFullName());
            $calEvent->startsAt($birthday);
            $calEvent->description((string) ($currentYear - $member->birthday->year));
            $calEvent->fullDay();
            $calendar->event($calEvent);

            //next year
            $birthdayNextYear = $member->birthday->clone();
            $birthdayNextYear->setYear($currentYear + 1);
            $calEvent = Event::create($member->getFullName());
            $calEvent->startsAt($birthdayNextYear);
            $calEvent->description((string) ($currentYear + 1 - $member->birthday->year));
            $calEvent->fullDay();
            $calendar->event($calEvent);
        }
    }

    private function getBirthdaySortedMembers(): Collection|array
    {
        return Member::getAllFiltered(new MemberFilter(true, true, true))
            ->whereNotNull('birthday')
            ->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
            });
    }

    private function addEventsToCalendar(Calendar $calendar, array $memberGroups = []): void
    {
        $eventFilter = new EventFilter;
        $eventFilter->memberGroups = $memberGroups;

        foreach (\App\Models\Event::getAllFiltered($eventFilter)->get() as $event) {
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
                $end->setTime(0,0);
            }
            $calEvent->endsAt($end);
            $calendar->event($calEvent);
        }
    }
}
