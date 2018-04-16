<?php

namespace App\Services;

use FacebookAds\Api;
use FacebookAds\Cursor;
use FacebookAds\Exception\Exception;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AbstractCrudObject;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdsInsights;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Fields\AdsInsightsFields;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\User;
use Rabiloo\Facebook\Facade\Facebook;

class FacebookAds
{
    /**
     * Max number items per page
     */
    const MAX_PER_PAGE = 1000;

    /**
     * Facebook constructor.
     *
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $api = Api::init(
            Facebook::getApp()->getId(),
            Facebook::getApp()->getSecret(),
            $accessToken
        );

        $api->setDefaultGraphVersion(str_replace('v', '', config('services.facebook.version', '')));

        if (env('APP_DEBUG')) {
            $logfile = storage_path('logs/facebook-ads.log');
            $resource = fopen($logfile, 'a');

            fwrite($resource, date('[Y-m-d H:i:s]') . PHP_EOL);

            $api->setLogger(new CurlLogger($resource));
        }
    }

    /**
     * Get all Facebook Ad accounts
     *
     * @return array
     * @throws FacebookSDKException
     */
    public function getAdAccounts()
    {
        $me = new User('me');
        $fields = [
            AdAccountFields::ID,
            AdAccountFields::ACCOUNT_ID,
            AdAccountFields::ACCOUNT_STATUS,
            AdAccountFields::NAME,
            AdAccountFields::CURRENCY,
            AdAccountFields::BALANCE,
        ];

        /** @var Cursor $cursor */
        $cursor = $me->getAdAccounts($fields, ['limit' => self::MAX_PER_PAGE]);

        // TODO: load before and after

        return array_map(function ($account) {
            /**@var AdAccount $account */
            return $account->exportAllData();
        }, $cursor->getArrayCopy());
    }

    /**
     * Get all Facebook Pages
     *
     * @return array
     * @throws FacebookSDKException
     */
    public function getPages()
    {
        $me = new User('me');
        $fields = [
            'id',
            'name',
            'link',
            'picture',
            'access_token',
            'perms',
            'about',
            'category',
        ];

        /** @var Cursor $cursor */
        $cursor = $me->getAccounts($fields, ['limit' => self::MAX_PER_PAGE]);

        // TODO: load before and after

        return array_map(function ($account) {
            /**@var AbstractCrudObject $account */
            return $account->exportAllData();
        }, $cursor->getArrayCopy());
    }

    /**
     * List all campaigns of an ad account
     *
     * @param string $adAccountId
     * @return array
     */
    public function getCampaigns($adAccountId)
    {
        $adAccount = new AdAccount($adAccountId);
        $fields = [
            CampaignFields::ID,
            CampaignFields::NAME,
            CampaignFields::ACCOUNT_ID,
            CampaignFields::START_TIME,
            CampaignFields::STOP_TIME,
            CampaignFields::CREATED_TIME,
            CampaignFields::UPDATED_TIME,
            CampaignFields::STATUS,
        ];

        /** @var Cursor $cursor */
        $cursor = $adAccount->getCampaigns($fields, ['limit' => self::MAX_PER_PAGE]);

        // TODO: load before and after

        return array_map(function ($campaign) {
            /**@var Campaign $campaign */
            return $campaign->exportAllData();
        }, $cursor->getArrayCopy());
    }

    /**
     * List all ads insights of a campaign
     *
     * @param string $campaignId
     * @param string $since Date format Y-m-d
     * @param string $until Date format Y-m-d
     * @return array
     */
    public function getAdsInsights($campaignId, $since, $until)
    {
        $campaign = new Campaign($campaignId);
        $fields = [
            AdsInsightsFields::ACCOUNT_ID,
            AdsInsightsFields::CAMPAIGN_ID,
            AdsInsightsFields::ACTIONS,
            AdsInsightsFields::CLICKS,
            AdsInsightsFields::IMPRESSIONS,
            AdsInsightsFields::SPEND,
            AdsInsightsFields::DATE_START,
            AdsInsightsFields::DATE_STOP,
        ];

        $params = [
            'time_range' => compact('since', 'until'),
            'time_increment' => 1
        ];

        /** @var Cursor $cursor */
        $cursor = $campaign->getInsights($fields, $params);

        // TODO: load before and after

        return array_map(function ($insight) {
            /**@var AdsInsights $insight */
            return $insight->exportAllData();
        }, $cursor->getArrayCopy());
    }
}
