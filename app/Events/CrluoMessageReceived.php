<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Storage;

class CrluoMessageReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var CreativeroomMessage
     */
    public $message;

    /**
     * @var string
     */
    public $user;

    /**
     * @var int
     */
    protected $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $userId)
    {
        $this->message = $message;
        $this->userId  = $userId;
        $this->user['name'] = $message->user->name;
        if ($path = $message->user->photo) {
            $this->user['photo'] = Storage::disk('s3')->url($path);
        } else {
            $this->user['photo'] = '/images/user.png';
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.' . $this->message->creativeroom_id . '.' . $this->userId);
    }
}
