<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function createUserAndLogin(string $name, string $email, NewUserProvider $provider, string $password = ''): User
    {
        $user = $this->createUser($name, $email, $provider, $password);
        Auth::login($user);

        return $user;
    }

    public function createUser(string $name, string $email, NewUserProvider $provider, string $password = ''): User
    {
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        Log::channel('userManagement')->info("User {$user->getNameWithMail()} has been created via $provider->value");
        User::getAdmins()->each(function (User $adminUser) use ($user, $provider) {
            $adminUser->notify(new NewUser($user, $provider));
        });

        return $user;
    }
}
