<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PushSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        Auth::user()->updatePushSubscription(
            $validated['endpoint'],
            $validated['keys']['p256dh'],
            $validated['keys']['auth'],
            'aesgcm'
        );

        return response()->json(['status' => 'subscribed']);
    }

    public function destroy(Request $request)
    {
        $request->validate(['endpoint' => 'required|string']);

        Auth::user()->removePushSubscription($request->input('endpoint'));

        return response()->json(['status' => 'unsubscribed']);
    }
}