<?php

namespace App\Http\Controllers\Auth;

use App\Facade\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class OAuthLoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function google(): RedirectResponse
    {
        $user = Socialite::driver('google')->user();

        return $this->tryLogin($user);
    }

    private function tryLogin(\Laravel\Socialite\Contracts\User $user): RedirectResponse
    {

        $userModel = $this->findUser($user->getEmail());

        if (!$userModel && env('OAUTH_AUTO_CREATE_USER')) {
            $userModel = $this->createUser($user->getEmail(), $user->getName());
        }

        if (!$userModel) {
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

        $user = User::create([
            'name' => $name,
            'email' => $email,
        ]);

        $user->register();

        Log::channel('userManagement')->info('User ' . $email . ' has been created by Oauth auto registration.');
        NotificationMessage::addNotificationMessage(
            new Item(__('User :user created successfully.', ['user' => $name]), ItemType::SUCCESS));

        return $user;
    }
}
