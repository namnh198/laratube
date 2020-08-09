<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Channel $channel) {
        return $channel->subscriptions()->create([
            'user_id' => auth()->user()->id
        ]);
    }

    public function destroy(Channel $channel, Subscription $subscription) {
        $subscription->delete();

        return response()->json([]);
    }
}
