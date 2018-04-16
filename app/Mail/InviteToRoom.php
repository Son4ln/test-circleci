<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\CreativeRoom;
use App\User;

class InviteToRoom extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var CreativeRoom
     */
    protected $room;

    /**
     * @var User
     */
    protected $invitee;

    /**
     * @var string
     */
    protected $token;

    /**
     * InviteToRoom constructor.
     *
     * @param CreativeRoom $room
     * @param User $invitee
     * @param string $token
     */
    public function __construct($room, $invitee, $token)
    {
        $this->room = $room;
        $this->invitee = $invitee;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】Projectへご招待されました。')
            ->view('emails.invite_to_room', [
                'room' => $this->room,
                'inviter' => $this->room->owner,
                'invitee' => $this->invitee,
                'token' => $this->token,
            ]);
    }
}
