<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoomHasMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var CreativeRoom
     */
    protected $room;

    /**
     * @var int
     */
    protected $role;


    /**
     * @var array
     */
    protected $roles = [
        1 => 'member',
        2 => 'member',
        3 => 'manager'
    ];

    /**
     * @var User
     */
    protected $sendUserInfo;

    /**
     * @var CreativeroomMessageRepositoryInterface
     */
    protected $sendMsgInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($room, $role , $sendUserInfo = null,$sendMsgInfo = null)
    {
        $this->room = $room;
        $this->role = $role;
        $this->sendUserInfo = $sendUserInfo;
        $this->sendMsgInfo  = $sendMsgInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = 'has_'.$this->roles[$this->role].'_message';

        return $this->subject('【CRLUO】Project')
            ->view('emails.'.$view, [
                'room'          => $this->room,
                'sendUserInfo'  => $this->sendUserInfo,
                'sendMsgInfo'   => $this->sendMsgInfo
            ]);
    }
}
