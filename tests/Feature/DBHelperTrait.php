<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Support\Facades\Hash;

trait DBHelperTrait
{
    use InteractsWithAuthentication, MakesHttpRequests;

    protected ?User $testUser;

    private function createAndLoginUser(string $userPermission = null): void
    {
        $email = fake()->email();
        $pass = fake()->password(8);
        $this->testUser = User::factory()->create([
            'name' => 'A User',
            'email' => $email,
            'password' => Hash::make($pass),
        ]);

        if ($userPermission) {
            $this->testUser->userPermissions()->attach($userPermission);
        }

        $response = $this->post('/login', [
            'email' => $email,
            'password' => $pass,
        ]);
        $this->assertAuthenticatedAs($this->testUser);
    }
}
