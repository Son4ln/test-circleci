<?php

namespace App\Listeners;

use App\Events\SocialUserWasLogged;
use Facebook\Authentication\AccessToken;
use Illuminate\Support\Facades\Auth;
use Rabiloo\Facebook\Facade\Facebook;

class LoginByFacebook
{
    /**
     * Handle the event.
     *
     * @param  SocialUserWasLogged  $event
     * @return void
     */
    public function handle(SocialUserWasLogged $event)
    {
        if ($event->network !== 'facebook') {
            return;
        }

        $accessToken = $event->socialUser->token;
        if (!($accessToken instanceof AccessToken && $accessToken->isLongLived())) {
            $accessToken = Facebook::getOAuth2Client()->getLongLivedAccessToken($event->socialUser->token);
        }

        $event->user->fill([
            'facebook_id' => $event->socialUser->getId(),
            'facebook_token' => $accessToken->getValue(),
            'facebook_name' => $event->socialUser->getName(),
        ]);

        $event->user->saveOrFail();

        Auth::setUser($event->user);
    }
}
