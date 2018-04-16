<?php

namespace App\Listeners;

use App\Events\ProposalWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Message;
use App\Project;

class SendProposalMessage
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
     * @param  ProposalWasCreated  $event
     * @return void
     */
    public function handle(ProposalWasCreated $event)
    {
        $project = Project::findOrFail($event->proposal['project_id']);

/*
        Message::create([
            'user_id'      => $event->proposal['user_id'],
            'send_user_id' => $project->user->id,
            'kind'         => 1,
            'title'        => 'I just propose for your project!',
            'message'      => 'Please check your project to see details',
        ]);
*/
    }
}
