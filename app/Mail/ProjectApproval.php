<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class ProjectApproval extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $projectTitle;
    protected $projectType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $projectType, $projectTitle)
    {
        $this->projectTitle = $projectTitle;
        $this->projectType = $projectType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】新しい'.$this->projectType.'が開始されました')
            ->view('emails.project_approval', [
                'projectTitle' => $this->projectTitle,
                'projectType' => $this->projectType

            ]);
    }
}
