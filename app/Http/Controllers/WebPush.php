<?php

namespace App\Http\Controllers;

use App\Models\WebPushSubscription;
use Illuminate\Http\Request;

class WebPush extends Controller
{
    public function vapidPublicKey()
    {
        return response()->json(['public_key' => config('webpush.vapid')['public_key']], 200);
    }

    public function hasEndpoint(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
        ]);

        $subscription = WebPushSubscription::findByEndpoint($request->endpoint);

        return response(null, $subscription ? 200 : 404);
    }

    public function removeEndpoint(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
        ]);

        $subscription = WebPushSubscription::findByEndpoint($request->endpoint);
        if ($subscription === null) {
            return response(null, 404);
        }
        $done = $subscription?->delete();

        return response(null, $done ? 200 : 500);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];

        //        dd( [
        //            'public_key' => $key,
        //            'auth_token' => $token,
        //            'user_id' => auth()->user()?->id
        //        ]);
        WebPushSubscription::query()->updateOrCreate([
            'endpoint' => $endpoint,
        ], [
            'user_id' => auth()->user()?->id,
            'public_key' => $key,
            'auth_token' => $token,
        ]);

        return response(null, 200);
    }
}
