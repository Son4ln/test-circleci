<?php

namespace Rabiloo\Facebook\Facade;

use Facebook\Authentication\AccessToken;
use Facebook\Authentication\OAuth2Client;
use Facebook\Facebook as FacebookSDK;
use Facebook\FacebookApp;
use Facebook\FacebookClient;
use Facebook\FacebookResponse;
use Facebook\Helpers\FacebookCanvasHelper;
use Facebook\Helpers\FacebookJavaScriptHelper;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Illuminate\Support\Facades\Facade;

/**
 * Class Facebook
 *
 * @method static FacebookApp getApp()
 * @method static FacebookClient getClient()
 * @method static OAuth2Client getOAuth2Client()
 * @method static FacebookCanvasHelper getCanvasHelper()
 * @method static FacebookJavaScriptHelper getJavaScriptHelper()
 * @method static FacebookRedirectLoginHelper getRedirectLoginHelper()
 * @method static FacebookPageTabHelper getPageTabHelper()
 *
 * @method static void setDefaultAccessToken(AccessToken|string $accessToken)
 * @method static AccessToken|null getDefaultAccessToken()
 *
 * @method static string getDefaultGraphVersion()
 *
 * @method static FacebookResponse get(string $endpoint, AccessToken|string|null $accessToken = null, string|null $eTag = null, string $graphVersion = null)
 * @method static FacebookResponse post(string $endpoint, array $params = [], AccessToken|string|null $accessToken = null, string|null $eTag = null, string $graphVersion = null)
 */
class Facebook extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FacebookSDK::class;
    }
}
