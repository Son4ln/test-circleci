<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectNeedPublic extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $projectTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $projectTitle)
    {
        $this->userName = $userName;
        $this->projectTitle = $projectTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【CRLUO】仕事依頼の登録')
            ->view('emails.project_need_public', [
                'userName' => $this->userName,
                'projectTitle' => $this->projectTitle
            ]);
    }
}
