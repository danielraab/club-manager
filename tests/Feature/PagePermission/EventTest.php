<?php

namespace Tests\Feature\PagePermission;

use App\Models\Event;
use App\Models\EventType;
use App\Models\UserPermission;

class EventTest extends TestPagePermission
{
    protected function doAdditionalSeeds(): void
    {
        Event::factory()->create();
        EventType::factory()->create();
    }

    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            Event::EVENT_EDIT_PERMISSION,
        ];
    }

    public function getRoutesWithPermissions(): array
    {
        return [
            '/events' => null,
            '/events/1/detail' => null,
            '/events/calendar' => null,
            '/events/ics' => null,
            '/events/json' => null,
            '/events/next' => null,
            '/events/statistic' => [],
            '/events/list/excel' => [],
            '/events/list/csv' => [],
            '/events/event/create' => [Event::EVENT_EDIT_PERMISSION],
            '/events/event/1' => [Event::EVENT_EDIT_PERMISSION],
            '/events/types' => [Event::EVENT_EDIT_PERMISSION],
            '/events/types/create' => [Event::EVENT_EDIT_PERMISSION],
            '/events/types/1' => [Event::EVENT_EDIT_PERMISSION],
        ];
    }
}
