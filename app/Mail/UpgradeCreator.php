<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpgradeCreator extends Mailable
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
        return $this->subject('【CRLUO】クリエイター登録者のお知らせ')
            ->view('emails.upgrade_creator', [
                'userName' => $this->userName
            ]);
    }
}
