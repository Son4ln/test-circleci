<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HasCreativeRoomMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var CreativeRoom
     */
    protected $creativeRoom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($creativeRoom)
    {
        $this->creativeRoom = $creativeRoom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】Project')
            ->view('emails.has_creative_room_message', [
                'creativeRoom' => $creativeRoom
            ]);
    }
}
