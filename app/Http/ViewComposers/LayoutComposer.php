<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LayoutComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->user = Auth::user();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
     public function compose(View $view)
     {
        $view->with('mode', $this->getMode());
        if (!$this->user) return;
        $view->with('unreadNof', $this->user
             ->unreadNotifications()
             ->where('type', 'App\Notifications\AlertRoomMessage')->count());

        $view->with('unreadMessage', $this->user
             ->unreadNotifications()
             ->where('type', 'App\Notifications\AlertMessage')->count());
     }

     /**
      * Get current mode
      *
      * @return 'client' | 'creator'
      */
     protected function getMode()
     {
         if (auth()->user() && auth()->user()->isClient() && auth()->user()->isCreator()) {
             $mode = Request::cookie('mode') ?? 'client';

             return $mode;
         }

         if (auth()->user() && auth()->user()->isCreator()) {
             return 'creator';
         }

         return 'client';
     }
}
