<?php

namespace Tests\Feature\PagePermission;

use App\Models\News;
use App\Models\UserPermission;

class NewsTest extends TestPagePermission
{
    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            News::NEWS_EDIT_PERMISSION,
        ];
    }

    public static function routesWithPermissionProvider(): array
    {
        return [
//            ['/news/1/detail', null],
            ['/news', []],
            ['/news/news/create', [News::NEWS_EDIT_PERMISSION]],
//            ['/news/news/1', [News::NEWS_EDIT_PERMISSION]],
        ];
    }
}
