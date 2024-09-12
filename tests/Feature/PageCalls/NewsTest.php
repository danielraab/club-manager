<?php

namespace Tests\Feature\PageCalls;

class NewsTest extends TestPageCall
{
    public function getOpenRoutes(): array
    {
        return [
            route('news.detail'),
        ];
    }

    public function getRestrictedRoutes(): array
    {
        return [
            route('news.create'),
        ];
    }

    public function getLoggedInOnlyRoutes(): array
    {
        return [
            route('news.index'),
        ];
    }
}
