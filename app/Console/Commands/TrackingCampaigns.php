<?php

namespace App\Console\Commands;

use App\Jobs\TrackingCampaign;
use App\TrackingJob;
use Illuminate\Console\Command;

class TrackingCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tracking all campaigns';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jobs = TrackingJob::all();

        foreach ($jobs as $job) {
            TrackingCampaign::dispatch($job)->onQueue('tracking');
        }
    }
}
