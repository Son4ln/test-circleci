<?php

namespace App\Providers;

use App\Repositories\ActivationTokenRepository;
use App\Repositories\CreativeroomMessageRepository;
use App\Repositories\CreativeRoomRepository;
use App\Repositories\DatabaseActivationTokenRepository;
use App\Repositories\FileRepository;
use App\Repositories\Interfaces\CreativeroomMessageRepositoryInterface;
use App\Repositories\Interfaces\CreativeRoomRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Rabiloo\Facebook\FacebookServiceProvider;
use Rabiloo\Sendgrid\SendgridServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $repositories = [
        CreativeRoomRepositoryInterface::class => CreativeRoomRepository::class,
        CreativeroomMessageRepositoryInterface::class => CreativeroomMessageRepository::class,
        FileRepositoryInterface::class => FileRepository::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCurrency('JPY', '¥');
        Validator::extend('activated_user_unique', function ($attribute, $value, $parameters, $validator) {
            $table = array_shift($parameters);
            $user = DB::table($table)->select(DB::raw(1))
                ->where($attribute, $value)
                ->where(function($query) {
                    $query->where(function($query) {
                        $query->where('created_at', '>', \Carbon\Carbon::now()->subHours(2)->toDateTimeString())
                        ->whereNull('activated_at');
                    })->orWhereNotNull('activated_at');
                })->first();
            return empty($user);
        });
        Validator::extend('new_rule_password', function ($attribute, $value, $parameters, $validator) {
            if( empty( $value ) )
                return true;
            
            if( strlen( trim($value) ) < 8 )
                return false;

            return preg_match('/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/', $value );
        }, __('users.new_password.error'));
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerActivationTokenRepository();
        $this->registerRepositories();

        $this->app->register(FacebookServiceProvider::class);
        $this->app->register(SendgridServiceProvider::class);
        $this->app->register(DuskServiceProvider::class);
    }

    /**
     * Register ActivationTokenRepository
     */
    protected function registerActivationTokenRepository()
    {
        $this->app->bind(ActivationTokenRepository::class, function () {
            $config = config('auth.activates', []);

            return new DatabaseActivationTokenRepository(
                $this->app['db']->connection(),
                $this->app['hash'],
                $config['table'] ?? 'activation_tokens',
                $config['key'] ?? env('APP_KEY'),
                $config['expire'] ?? 120
            );
        });
    }

    /**
     * Register repositories
     */
    protected function registerRepositories()
    {
        // $this->app->register(RepositoryServiceProvider::class);
        foreach ($this->repositories as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }
}
