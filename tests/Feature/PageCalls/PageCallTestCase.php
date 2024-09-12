<?php

namespace Tests\Feature\PageCalls;

use Database\Seeders\Minimal\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class PageCallTestCase extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_with_permission(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/login', [
            'email' => UserSeeder::ADMIN_MAIL,
            'password' => UserSeeder::ADMIN_PASSWORD,
        ]);
        $this->assertAuthenticated();

        $this->doRouteTests($this->getOpenRoutes(), 200);
        $this->doRouteTests($this->getLoggedInOnlyRoutes(), 200);
        $this->doRouteTests($this->getRestrictedRoutes(), 200);
    }

    public function test_logged_in_no_permission(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/login', [
            'email' => UserSeeder::TESTER_MAIL,
            'password' => UserSeeder::TESTER_PASSWORD,
        ]);
        $this->assertAuthenticated();

        $this->doRouteTests($this->getOpenRoutes(), 200);
        $this->doRouteTests($this->getLoggedInOnlyRoutes(), 200);
        $this->doRouteTests($this->getRestrictedRoutes(), 403);
    }

    public function test_not_logged_in(): void
    {
        $this->doRouteTests($this->getOpenRoutes(), 200);
        $this->doRouteTests($this->getLoggedInOnlyRoutes(), 302);
        $this->doRouteTests($this->getRestrictedRoutes(), 302);
    }

    private function doRouteTests(array $routes, $status): void
    {
        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus($status);
        }
    }

    abstract public function getOpenRoutes(): array;

    abstract public function getLoggedInOnlyRoutes(): array;

    abstract public function getRestrictedRoutes(): array;
}
