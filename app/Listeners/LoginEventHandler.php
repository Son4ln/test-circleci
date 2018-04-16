<?php

namespace App\Listeners;

use Cache;
use Illuminate\Auth\Events\Login;
use Rabiloo\Facebook\Facade\Facebook;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginEventHandler
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        if ($user->facebook_id && !Cache::has('facebook_name.' . $user->facebook_id)) {
            $fbResponse = Facebook::get($user->facebook_id, $user->facebook_token);
            $fbUser = $fbResponse->getGraphUser()->asArray();

            Cache::remember('facebook_name.' . $user->facebook_id, 9999999 , function() use ($fbUser) {
                return $fbUser['name'];
            });
        }
    }
}
