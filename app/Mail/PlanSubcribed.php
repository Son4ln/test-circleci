<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlanSubcribed extends Mailable
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
        return $this->subject('【CRLUO】デポジット入金のお知らせ ')
            ->view('emails.plan_subcribed', [
                'userName' => $this->userName
            ]);
    }
}
