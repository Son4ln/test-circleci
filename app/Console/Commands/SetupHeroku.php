<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;

class SetupHeroku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:heroku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Heroku environment';

    /**
     * @var string
     */
    protected $env;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->env = config('app.env', 'production');

        if ($this->env === 'local') {
            $this->info('Skip on local environment');
            return 0;
        }

        $this->info(sprintf('System run on %s environment', $this->env));

        try {
            $this->generateSiteConf();
            // $this->generateLaravelEchoServerJson();
            $this->runMigrate();

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            $this->info($e->getTraceAsString());
            return 1;
        }

        $this->info('Setup Heroku environment successfully');
        return 0;
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function generateSiteConf()
    {
        $siteFile = base_path('site.conf');
        $stubPath = base_path('services/web');
        $siteStub = $stubPath . DIRECTORY_SEPARATOR . 'heroku-prod.conf';

        if ($this->env !== 'production') {
            $siteStub = $stubPath . DIRECTORY_SEPARATOR . 'heroku-dev.conf';
        }

        if (!copy($siteStub, $siteFile)) {
            throw new \Exception('Setup Heroku environment fail');
        }

        $this->info('>>> Generate site.conf done');
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function generateLaravelEchoServerJson()
    {
        $confFile = base_path('laravel-echo-server.json');
        $redis = config('database.redis.default');

        $config = [
            'authHost' => config('app.url'),
            'authEndpoint' => '/broadcasting/auth',
            'clients' => [],
            'database' => 'redis',
            'databaseConfig' => [
                'redis' => [
                    'host' => $redis['host'],
                    'port' => $redis['port'],
                    'db' => $redis['database'],
                ],
            ],
            'devMode' => $this->env !== 'production',
            'host' => null,
            'port' => '3000',
            'protocol' => 'http',
            'socketio' => [],
            'sslCertPath' => '',
            'sslKeyPath' => '',
            'sslCertChainPath' => '',
            'sslPassphrase' => ''
        ];

        if (isset($redis['password'])) {
            $config['databaseConfig']['redis']['password'] = $redis['password'];
        }

        if (!file_put_contents($confFile, json_encode($config, JSON_PRETTY_PRINT))) {
            throw new \Exception('Setup laravel echo server fail');
        }

        $this->info('>>> Generate laravel-echo-server.json done');
    }

    /**
     * @return void
     */
    protected function runMigrate()
    {
        if ($this->env !== 'production') {
            $this->callSilent('migrate');
        }

        $this->info('>>> Run migrate done');
    }
}
