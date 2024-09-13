<?php

namespace Tests\Feature\PagePermission;

use App\Models\UserPermission;
use Tests\Feature\DBHelperTrait;

class UserManagementTest extends TestPagePermission
{
    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
            UserPermission::USER_MANAGEMENT_SHOW_PERMISSION,
            UserPermission::USER_MANAGEMENT_EDIT_PERMISSION,
        ];
    }

    public function getRoutesWithPermissions(): array
    {
        return [
            '/userManagement' => [UserPermission::USER_MANAGEMENT_SHOW_PERMISSION, UserPermission::USER_MANAGEMENT_EDIT_PERMISSION],
            '/userManagement/user/create' => [UserPermission::USER_MANAGEMENT_EDIT_PERMISSION],
            '/userManagement/user/1' => [UserPermission::USER_MANAGEMENT_EDIT_PERMISSION],
        ];
    }
}
