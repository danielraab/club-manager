<?php

namespace App\Http\Controllers\Auth;

use App\Facade\NotificationMessage;
use App\Http\Controllers\Controller;
use App\NotificationMessage\Item;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        NotificationMessage::addNotificationMessage(new Item( __('A new verification link has been sent to your email address.')));

        return back();
    }
}
