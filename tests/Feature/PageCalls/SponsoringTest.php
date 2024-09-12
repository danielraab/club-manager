<?php

namespace Tests\Feature\PageCalls;

class SponsoringTest extends PageCallTestCase
{
    public function getOpenRoutes(): array
    {
        return [];
    }

    public function getRestrictedRoutes(): array
    {
        return [
            route('sponsoring.index'),
            route('sponsoring.backer.index'),
            route('sponsoring.ad-option.index'),
            route('sponsoring.package.index'),
            route('sponsoring.backer.create'),
            route('sponsoring.ad-option.create'),
            route('sponsoring.package.create'),
            route('sponsoring.period.create'),
            route('sponsoring.period.create'),
        ];
    }

    public function getLoggedInOnlyRoutes(): array
    {
        return [];
    }
}
