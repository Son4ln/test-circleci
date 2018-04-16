<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateCreator extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】クリエイター機能利用可能のお知らせ')
            ->view('emails.activate_creator', [
                'userName' => $this->userName
            ]);
    }
}
