<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class DevServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
        });

        Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            // $event->exception
        });

        Queue::before(function (JobProcessing $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });

        Queue::looping(function () {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        });
        */

        if (Str::startsWith(env('APP_URL'), 'https://')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_DEBUG', false) && env('APP_ENV', 'production') === 'local') {
            // Load DebugBar if it is installed
            if (class_exists('Barryvdh\Debugbar\ServiceProvider')) {
                $this->app->register('Barryvdh\Debugbar\ServiceProvider');
                $this->app->alias('Barryvdh\Debugbar\Facade', 'Debugbar');
            }

            // Load IDE helper
            if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
                $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
            }

            // Load Laravel Tinker
            if (class_exists('Laravel\Tinker\TinkerServiceProvider')) {
                $this->app->register('Laravel\Tinker\TinkerServiceProvider');
            }

            // Load Laracademy Make
            if (class_exists('Laracademy\Commands\MakeServiceProvider')) {
                $this->app->register('Laracademy\Commands\MakeServiceProvider');
            }

            // Load shpasser/gae-support-l5
            // composer require shpasser/gae-support-l5 --dev
            if (class_exists('Shpasser\GaeSupportL5\GaeSupportServiceProvider')) {
                $this->app->register('Shpasser\GaeSupportL5\GaeSupportServiceProvider');
            }

            if (class_exists('Laravel\Dusk\DuskServiceProvider')) {
                $this->app->register('Laravel\Dusk\DuskServiceProvider');
            }

        } elseif (env('APP_ENV', 'production') === 'testing') {
            if (class_exists('Laravel\Dusk\DuskServiceProvider')) {
                $this->app->register('Laravel\Dusk\DuskServiceProvider');
            }
            // Load DebugBar if it is installed
            if (class_exists('Barryvdh\Debugbar\ServiceProvider')) {
                $this->app->register('Barryvdh\Debugbar\ServiceProvider');
                $this->app->alias('Barryvdh\Debugbar\Facade', 'Debugbar');
            }
        }
    }
}
