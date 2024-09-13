<?php

namespace Tests\Feature\PagePermission;

use App\Models\News;
use App\Models\UserPermission;

class WebPushTest extends TestPagePermission
{
    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
        ];
    }

    public static function routesWithPermissionProvider(): array
    {
        return [
            ['/webPush/vapidPublicKey', null],
        ];
    }
}
