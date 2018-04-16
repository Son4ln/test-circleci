<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Coperation extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * @var string $emailFrom
    */
    var $emailFrom;

    /**
     * @var string $emailName
     */
    var $emailName;

    /**
     *  @var string $dateTime
     */
    var $_dateTime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailFrom, $emailName, $dateTime)
    {
        $this->emailFrom = $emailFrom;
        $this->emailName = $emailName;
        $this->_dateTime = $dateTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【crluo】C-Operationの問い合わせがありました。')
            ->view('emails.coperation');
    }
}
