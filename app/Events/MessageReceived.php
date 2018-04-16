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

class MessageReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var CreativeroomMessage
     */
    public $message;

    /**
     * @var array
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $this->transform($message);
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
        return new PresenceChannel('room.' . $this->message['creativeroom_id']);
    }

    private function transform($data)
    {
        return [
            'files' => $data->files,
            'message' => $data->message,
            'created_at' => $data->created_at->format('Y/m/d'),
            'creativeroom_id' => $data->creativeroom_id
        ];
    }
}
