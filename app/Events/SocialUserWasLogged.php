<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SocialUserWasLogged
{
    use Dispatchable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var \Laravel\Socialite\Contracts\User
     */
    public $socialUser;

    /**
     * @var string
     */
    public $network;

    /**
     * Create a new event instance.
     *
     * @param User   $user
     * @param mixed  $socialUser
     * @param string $network
     */
    public function __construct(User $user, $socialUser, $network)
    {
        $this->user = $user;
        $this->socialUser = $socialUser;
        $this->network = $network;
    }
}
