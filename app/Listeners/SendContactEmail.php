<?php

namespace App\Listeners;

use App\Events\ContactWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\Contact;
use App\Mail\ContactReply;

class SendContactEmail
{
    /**
     * @var string
     */
    protected $mailTo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mailTo = 'vulgoplus@gmail.com';
    }

    /**
     * Handle the event.
     *
     * @param  ContactWasCreated  $event
     * @return void
     */
    public function handle(ContactWasCreated $event)
    {
        Mail::to($this->mailTo)
            ->send(new Contact($event->data));

        Mail::to($event->data['email'])
            ->send(new ContactReply($event->data));
    }
}
