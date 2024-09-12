<?php

namespace Tests\Feature\PageCalls;

class EventTest extends TestPageCall
{
    public function getOpenRoutes(): array
    {
        return [
            route('event.index'),
            route('event.calendar'),
            route('event.iCalendar'),
            route('event.json'),
            route('event.next'),
        ];
    }

    public function getRestrictedRoutes(): array
    {
        return [
            route('event.create'),
            route('event.type.index'),
            route('event.type.create'),
        ];
    }

    public function getLoggedInOnlyRoutes(): array
    {
        return [
            route('event.statistic'),
            route('event.list.excel'),
            route('event.list.csv'),
        ];
    }
}
