<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Facades\Auth;

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
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->status->user ?? $event->user_info->user ?? false;
        if ($user) {
            Auth::setUser($user);
            ResponseCache::forget('/user/profile');
            ResponseCache::forget('/users/' . $user->slug);
        }
    }
}
