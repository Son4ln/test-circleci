<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Permission' => 'App\Policies\PermissionPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Info' => 'App\Policies\NewsPolicy',
        'App\Payment' => 'App\Policies\PaymentPolicy',
        'App\Portfolio' => 'App\Policies\PortfolioPolicy',
        'App\Project' => 'App\Policies\ProjectPolicy',
        'App\ProjectFile' => 'App\Policies\ProjectFilePolicy',
        'App\Proposal' => 'App\Policies\ProposalPolicy',
        'App\Reword' => 'App\Policies\RewordPolicy',
        'App\CreativeRoom' => 'App\Policies\RoomPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
