<?php

namespace App\Events;

use App\Project;
use App\ProjectFile;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PreviewFileWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var ProjectFile
     */
    protected $file;

    /**
     * Create a new event instance.
     *
     * @param Project     $project
     * @param ProjectFile $file
     */
    public function __construct($project, $file)
    {
        $this->project = $project;
        $this->file = $file;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
