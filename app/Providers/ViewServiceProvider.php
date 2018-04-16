<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.left_nav', function (\Illuminate\View\View $view) {
            $view->with('me', Auth::user());
        });

        View::composer(
            'layouts.ample', 'App\Http\ViewComposers\LayoutComposer'
        );
    }
}
