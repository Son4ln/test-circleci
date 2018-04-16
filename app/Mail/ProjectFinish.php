<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectFinish extends Mailable
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
    public function __construct(string $projectName)
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
        return $this->subject('【CRLUO】検収完了 ')
            ->view('emails.project_finish', [
                'projectName' => $this->projectName
            ]);
    }
}
