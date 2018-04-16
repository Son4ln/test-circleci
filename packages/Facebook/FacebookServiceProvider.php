<?php

namespace Rabiloo\Facebook;

use Facebook\Facebook;
use GuzzleHttp\Client;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\ServiceProvider;
use Rabiloo\Facebook\Facade\Facebook as FacebookFacade;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/services.php', 'services');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Facebook::class, function () {
            $config = $this->app['config']['services.facebook'];
            $fbConfig = [
                'app_id' => $config['client_id'] ?? '',
                'app_secret' => $config['client_secret'] ?? '',
                'default_graph_version' => $config['version'] ?? 'v2.9',
                'enable_beta_mode' => $config['beta_mode'] ?? false,
                'http_client_handler' => new Guzzle6HttpClient(new Client()),
                'persistent_data_handler' => null,
                'pseudo_random_string_generator' => null,
                'url_detection_handler' => null,
            ];

            if ($this->app->bound(Session::class)) {
                $fbConfig['persistent_data_handler'] = new LaravelPersistentDataHandler(
                    $this->app->make(Session::class)
                );
            }

            if ($this->app->bound(UrlGenerator::class)) {
                $fbConfig['url_detection_handler'] = new LaravelUrlDetectionHandler(
                    $this->app->make(UrlGenerator::class)
                );
            }

            return new Facebook($fbConfig);
        });

        $this->app->alias(FacebookFacade::class, 'Facebook');
    }
}
