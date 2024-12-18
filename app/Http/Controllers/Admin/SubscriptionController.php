<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        // Ver suscripciones de usuarios
        $subscriptions = Subscription::with('user')->paginate(20);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function extend(User $user, Request $request)
    {
        // Extender suscripción 30 días más (o configurable)
        $days = config('app.subscription_days', 30); // Podemos definirlo en .env
        $expiresAt = Carbon::now()->addDays($days);

        if ($user->subscription) {
            $user->subscription->update(['expires_at' => $expiresAt]);
        } else {
            Subscription::create(['user_id' => $user->id, 'expires_at' => $expiresAt]);
        }

        return redirect()->route('admin.subscriptions.index')->with('status', 'Suscripción extendida hasta '.$expiresAt);
    }
}
