<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeRole extends Mailable
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
        return $this->subject('【CRLUO】権限変更のお知らせ')
            ->view('emails.change_role', [
                'userName' => $this->userName
            ]);
    }
}
