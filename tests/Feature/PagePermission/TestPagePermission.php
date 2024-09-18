<?php

namespace Tests\Feature\PagePermission;

use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\DBHelperTrait;
use Tests\TestCase;

class TestPagePermission extends TestCase
{
    use DBHelperTrait, RefreshDatabase;

    public function test_not_logged_in(): void
    {
        $this->doAdditionalSeeds();
        foreach ($this->getRoutesWithPermissions() as $route => $permissions) {
            $this->doRouteTest($route, $permissions, null);
        }
    }

    protected function doAdditionalSeeds(): void {}

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

    public function test_logged_in_no_permission(): void
    {
        $this->doAdditionalSeeds();
        foreach ($this->getRoutesWithPermissions() as $route => $permissions) {
            $this->createAndLoginUser();
            $this->doRouteTest($route, $permissions, '');
            $this->logout();
        }
    }

    private function logout(): void
    {
        $this->post('/logout');
        $this->assertGuest();
    }

    public function test_logged_in_with_permission(): void
    {
        $this->doAdditionalSeeds();
        foreach ($this->getRoutesWithPermissions() as $route => $permissions) {
            foreach ($this->getPermissionsToTest() as $userPermission) {
                $this->createAndLoginUser($userPermission);
                $this->doRouteTest(
                    $route,
                    $permissions,
                    $userPermission
                );
                $this->logout();
            }
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
    public function getRoutesWithPermissions(): array
    {
        return [
            '/' => null,
            '/dashboard' => null,
            '/imprint' => null,
            '/privacy-policy' => null,
            '/profile' => [],
            '/settings' => [UserPermission::ADMIN_USER_PERMISSION],
            '/files' => [UserPermission::ADMIN_USER_PERMISSION],
        ];
    }
}
