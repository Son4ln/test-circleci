<?php

namespace App\Console\Commands;

use Mail;
use Illuminate\Console\Command;
use App\Mail\ProjectExpireAtToday;
use App\Mail\ProjectExpireAfterThreeDay;

class SendProjectMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:project-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notification for expired projects';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projectsExpireAtToday = \App\Project::select('id', 'user_id', 'title')->with('user:id,name,email')
            ->where('status', \App\Project::PUBLIC_STATUS)
            ->whereRaw("(expired_at::date - ?::date) = 0", date('Y-m-d'))
            ->get();

        $projectsExpireAfterThreeDay = \App\Project::select('id', 'user_id', 'title')->with('user:id,name,email')
            ->where('status', \App\Project::PUBLIC_STATUS)
            ->whereRaw("(expired_at::date - ?::date) = 3", date('Y-m-d'))
            ->get();

        \App\Project::where('status', \App\Project::PUBLIC_STATUS)
            ->whereRaw("(expired_at::date - ?::date) < 0", date('Y-m-d'))
            ->update('status', 20);

        foreach ($projectsExpireAtToday as $project) {
            Mail::to($project->user->email)
                ->queue(new ProjectExpireAtToday($project->user->name, $project->title));
        }

        foreach ($projectsExpireAfterThreeDay as $project) {
            Mail::to($project->user->email)
                ->queue(new ProjectExpireAfterThreeDay($project->user->name, $project->title));
        }
    }
}
