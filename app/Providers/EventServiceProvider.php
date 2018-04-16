<?php

namespace App\Providers;

use App\Events\SocialUserWasLogged;
use App\Listeners\LoginByFacebook;
use App\Listeners\SendActivationMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendActivationMail::class,
        ],
        SocialUserWasLogged::class => [
            LoginByFacebook::class,
        ],
        'App\Events\ContactWasCreated' => [
            'App\Listeners\SendContactEmail'
        ],
        'App\Events\ProposalWasCreated' => [
            'App\Listeners\SendProposalMessage'
        ],
        'App\Events\EmailShouldBeSent' => [
            'App\Listeners\SendAdminMail'
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LoginEventHandler'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
