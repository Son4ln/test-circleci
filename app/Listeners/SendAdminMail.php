<?php

namespace App\Listeners;

use App\Events\EmailShouldBeSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Mail;

class SendAdminMail
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
     * @param  EmailShouldBeSent  $event
     * @return void
     */
    public function handle(EmailShouldBeSent $event)
    {
/*        $admins = User::role('admin')->get(['email']);

        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue($event->mail);
        }
        */
        Mail::to("rokesuta@crluo-mail.com")->queue($event->mail);

    }
}
