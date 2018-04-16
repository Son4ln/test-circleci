<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PreviewFile extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $roomName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($roomName)
    {
        $this->roomName = $roomName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】プレビューアップロード ')
            ->view('emails.preview_file', [
                'roomName' => $this->roomName
            ]);
    }
}
