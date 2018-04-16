<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectActivated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $projectTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectTitle)
    {
        $this->projectTitle = $projectTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】「仕事依頼」公開のお知らせ')
            ->view('emails.project_activated', [
                'projectTitle' => $this->projectTitle
            ]);
    }
}
