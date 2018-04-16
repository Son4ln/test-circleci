<?php

namespace Rabiloo\Sendgrid;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Rabiloo\Sendgrid\Mail\Transport\SendgridTransport;

class SendgridServiceProvider extends ServiceProvider
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
     * Register the Swift Transport instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving(TransportManager::class, function(TransportManager $manager) {
            $this->extendTransportManager($manager);
        });
    }

    /**
     * @param TransportManager $manager
     */
    public function extendTransportManager(TransportManager $manager)
    {
        $manager->extend('sendgrid', function() {
            $config = $this->app['config']->get('services.sendgrid', []);
            $client = new HttpClient(Arr::get($config, 'guzzle', []));

            return new SendgridTransport($client, $config['api_key']);
        });
    }
}
