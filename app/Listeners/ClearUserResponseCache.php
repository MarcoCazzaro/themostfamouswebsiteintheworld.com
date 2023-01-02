<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Spatie\ResponseCache\Facades\ResponseCache;

class ClearUserResponseCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param    $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->status->user ?? $event->user_info->user ?? false;
        if ($user) {
            Auth::setUser($user);
            ResponseCache::forget('/user/profile');
            ResponseCache::forget('/users/'.$user->slug);
        }
    }
}
