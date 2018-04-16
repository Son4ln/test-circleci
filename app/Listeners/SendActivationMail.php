<?php

namespace App\Listeners;

use App\Mail\UserActivation;
use App\Repositories\ActivationTokenRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationMail implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * @var ActivationTokenRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param ActivationTokenRepository $repository
     */
    public function __construct(ActivationTokenRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $token = $this->repository->create($event->user->email);

        Mail::to($event->user)
            ->send(new UserActivation($event->user, $token));
    }
}
