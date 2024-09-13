<?php

namespace Tests\Feature\PagePermission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\DBHelperTrait;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DBHelperTrait, RefreshDatabase;

    public function test_not_logged_in(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response = $this->get('/verify-email');
        $response->assertStatus(302);
        $response = $this->get('/confirm-password');
        $response->assertStatus(302);
    }

    public function test_logged_in(): void
    {
        $this->createAndLoginUser();

        $response = $this->get('/login');
        $response->assertStatus(302);
        $response = $this->get('/forgot-password');
        $response->assertStatus(302);
//        $response = $this->get('/verify-email');
//        $response->assertStatus(200);
//        $response = $this->get('/confirm-password');
//        $response->assertStatus(200);
    }
}
