<?php

namespace App\Http\Controllers;

use App\Models\WebPushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebPush extends Controller
{


    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];

        $user = Auth::user();
        WebPushSubscription::query()->create([
            'logged_in' => $user !== null,
            'endpoint' => $endpoint,
            'public_key' => $key,
            'auth_token' => $token,
        ]);

        return response()->json(['success' => true], 200);
    }
}
