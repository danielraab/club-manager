<?php

namespace Tests\Feature\PagePermission;

use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\DBHelperTrait;
use Tests\TestCase;

class TestPagePermission extends TestCase
{
    use DBHelperTrait, RefreshDatabase;

    /**
     * @dataProvider routesWithPermissionProvider
     */
    public function test_not_logged_in(string $route, ?array $permissions): void
    {
        $this->doAdditionalSeeds();
        $this->doRouteTest($route, $permissions, null);
    }

    protected function doAdditionalSeeds(): void
    {
    }

    private function doRouteTest(string $route, ?array $routePermissions, ?string $userPermissionCode): void
    {
        $response = $this->get($route);
        $response->assertStatus($this->getExpectedStatus($userPermissionCode, $routePermissions));
    }

    private function getExpectedStatus(?string $userPermissionCode, ?array $routePermissionCodes): int
    {
        if ($routePermissionCodes === null) {
            return 200;
        }
        if (count($routePermissionCodes) === 0) {
            return $userPermissionCode === null ? 302 : 200;
        }
        if ($userPermissionCode === null) {
            return 302;
        }
        if ($userPermissionCode === UserPermission::ADMIN_USER_PERMISSION) {
            return 200;
        }

        return in_array($userPermissionCode, $routePermissionCodes) ? 200 : 403;
    }

    /**
     * @dataProvider routesWithPermissionProvider
     */
    public function test_logged_in_no_permission(string $route, ?array $permissions): void
    {
        $this->createAndLoginUser();
        $this->doAdditionalSeeds();
        $this->doRouteTest($route, $permissions, '');
        $this->logout();
    }

    private function logout(): void
    {
        $this->post('/logout');
        $this->assertGuest();
    }

    /**
     * @dataProvider routesWithPermissionProvider
     */
    public function test_logged_in_with_permission(string $route, ?array $permissions): void
    {
        foreach ($this->getPermissionsToTest() as $userPermission) {
            $this->createAndLoginUser($userPermission);
            $this->doAdditionalSeeds();
            $this->doRouteTest(
                $route,
                $permissions,
                $userPermission
            );
            $this->logout();
        }
    }

    protected function getPermissionsToTest(): array
    {
        return [
            UserPermission::ADMIN_USER_PERMISSION,
        ];
    }

    /**
     * (key) string => (value) ?string
     * key: route
     * value:
     * - null -> open for un-auth
     * - empty arr -> open for logged in without permissions
     * - array with permissions -> open only for logged in with permissions
     */
    public static function routesWithPermissionProvider(): array
    {
        return [
            ['/', null],
            ['/dashboard', null],
            ['/imprint', null],
            ['/privacy-policy', null],
            ['/profile', []],
            ['/settings', [UserPermission::ADMIN_USER_PERMISSION]],
            ['/files', [UserPermission::ADMIN_USER_PERMISSION]],
        ];
    }
}
