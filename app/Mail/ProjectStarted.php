<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectStarted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $projectName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $projectName = "")
    {
        $this->projectName = $projectName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】セルフコンペ公開 ')
            ->view('emails.project_started', [
                'projectName' => $this->projectName
            ]);
    }
}
