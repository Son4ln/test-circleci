<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AlertRoomMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var CreativeRoom
     */
    protected $room;

    /**
     *
     */
    protected $kind;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($room, $kind = 1)
    {
        $this->room = $room;
        $this->kind = $kind;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "<b>{$this->room->title}</b>" . ' You have room message!',
            'link'    => route('creative-rooms.show', ['id' => $this->room->id]),
            'room_id' => $this->room->id,
            'type'    => 'room.' . $this->room->id. '.' . $this->kind,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'room_id' => $this->room->id,
            'kind'    => $this->kind
        ]);
    }
}
