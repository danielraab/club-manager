<?php

namespace Tests\Feature\PageCalls;

class MemberTest extends TestPageCall
{
    public function getOpenRoutes(): array
    {
        return [];
    }

    public function getRestrictedRoutes(): array
    {
        return [
            route('member.index'),
            route('member.list.csv'),
            route('member.list.excel'),
            route('member.birthdayList'),
            route('member.birthdayList.print'),

            route('member.import'),

            route('member.group.index'),
            route('member.group.create'),
            route('member.create'),
        ];
    }

    public function getLoggedInOnlyRoutes(): array
    {
        return [];
    }
}
