<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function confirm(Request $request): RedirectResponse
    {
        $request->validate(['token' => 'required']);

        $subscriber = Subscriber::query()->where('token', $request->token)->first();

        if (is_null($subscriber)) {
            return redirect()->route('home')->with('error', 'Invalid request');
        }

        $subscriber->update(['verified_at' => now()]);

        return redirect()->route('home')->with('success', 'Congratulation, we are connected now!');
    }

    public function unsubscribe(Request $request): RedirectResponse
    {
        $request->validate(['token' => 'required']);

        $subscriber = Subscriber::where('token', $request->token)->first();

        if (is_null($subscriber)) {
            return redirect()->route('home')->with('errorMsg', 'Invalid request');
        }

        $subscriber->update(['unsubscribed_at' => now()]);

        return redirect()->route('home')->with('successMsg', 'You have unsubscribed');
    }
}
