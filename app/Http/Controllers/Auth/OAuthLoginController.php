<?php

namespace App\Http\Controllers\Auth;

use App\Facade\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use App\Notifications\NewUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class OAuthLoginController extends Controller
{
    private string $provider = '';

    public function google(): RedirectResponse
    {
        $this->provider = 'google';

        return $this->handleRequest();
    }

    public function authentik(): RedirectResponse
    {
        $this->provider = 'authentik';

        return $this->handleRequest();
    }

    private function handleRequest(): RedirectResponse
    {
        try {
            $user = Socialite::driver($this->provider)->user();

            return $this->tryLogin($user);
        } catch (\InvalidArgumentException $e) {
            Log::error('Exception while logging in.', [$e]);
            NotificationMessage::addErrorNotificationMessage(__('A problem occurred, while logging in.').' '.__('Please try again.'));

            return redirect(route('login'));
        }
    }

    private function tryLogin(\Laravel\Socialite\Contracts\User $user): RedirectResponse
    {

        $userModel = $this->findUser($user->getEmail());

        if (! $userModel && config('services.oauth_auto_create_user')) {
            $userModel = $this->createUser($user->getEmail(), $user->getName());
        }

        if (! $userModel) {
            return redirect()->route('oauth.user-not-found');
        }

        $userModel->update([
            'last_login_at' => now(),
        ]);

        Auth::login($userModel);

        NotificationMessage::addSuccessNotificationMessage(__('Your login was successful.'));

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    private function findUser(string $email): ?User
    {
        return User::findByMail($email);
    }

    private function createUser(string $email, string $name): ?User
    {
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
        ]);

        $user->register();

        Log::channel('userManagement')->info('User '.$email.' has been created by Oauth auto registration.');
        User::getAdmins()->each(function (User $adminUser) use ($user) {
            $adminUser->notify(new NewUser($user, $this->provider));
        });
        NotificationMessage::addNotificationMessage(
            new Item(__('User :user created successfully.', ['user' => $name]), ItemType::SUCCESS));

        return $user;
    }
}
