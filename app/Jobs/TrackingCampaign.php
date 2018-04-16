<?php

namespace App\Jobs;

use App\Notifications\AlertCampaign;
use App\TrackingJob;
use App\User;
use App\Services\FacebookAds;
use Carbon\Carbon;
use FacebookAds\Exception\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TrackingCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TrackingJob
     */
    protected $tracking;

    /**
     * Create a new job instance.
     *
     * @param TrackingJob $job
     */
    public function __construct(TrackingJob $job)
    {
        $this->tracking = $job;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var User $user */
        $user = $this->tracking->user()->firstOrFail();

        if (empty($user->facebook_id) || empty($user->facebook_token)) {
            // TODO: not access token
            return;
        }

        try {
            $service = new FacebookAds($user->facebook_token);
            $today = Carbon::now()->format('Y-m-d');

            $adsInsights = $service->getAdsInsights($this->tracking->campaign_id, $today, $today);
            if (count($adsInsights) === 0) {
                // Get error
                return;
            }

            $this->processInsight($user, $adsInsights[0]);
        } catch (Exception $exception) {
            logger()->error(sprintf(
                "[%s] %s\n%s",
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getTraceAsString()
            ));

            // TODO: process error
        }
    }

    /**
     * @param User $user
     * @param array $insight
     * @return void
     */
    private function processInsight(User $user, $insight)
    {
        switch ($this->tracking->condition_type) {
            case TrackingJob::CONDITION_SPEND_GTE:
                if ($insight['spend'] >= $this->tracking->condition_value) {
                    $user->notify(new AlertCampaign([]));
                }
                break;
            case TrackingJob::CONDITION_PERCENT_CLICK_LTE:
                if ($insight['impressions'] != 0 &&
                    ($insight['clicks'] / $insight['impressions']) <= $this->tracking->condition_value
                ) {
                    $user->notify(new AlertCampaign([]));
                }
                break;
        }
    }
}
