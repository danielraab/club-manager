<?php

namespace Tests\Feature\PageCalls;

class AttendanceTest extends TestPageCall
{
    public function getOpenRoutes(): array
    {
        return [];
    }

    public function getRestrictedRoutes(): array
    {
        return [
            route('attendancePoll.index'),
            route('attendancePoll.create'),
        ];
    }

    public function getLoggedInOnlyRoutes(): array
    {
        return [];
    }
}
