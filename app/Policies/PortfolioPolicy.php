<?php

namespace App\Policies;

use App\User;
use App\Portfolio;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create portfolios.
     *
     * @param  User  $actor
     * @return bool
     */
    public function index(User $actor)
    {
        return $actor->enabled == 1;
    }

    /**
     * Determine whether the user can view the portfolio.
     *
     * @param  User  $actor
     * @param  Portfolio  $portfolio
     * @return bool
     */
    public function view(User $actor, Portfolio $portfolio)
    {
        if ($portfolio->isPublicScope()) {
            return true;
        }

        if ($portfolio->isClientScope()) {
            return $actor->isClient() || $actor->id == $portfolio->user_id;
        }

        if ($portfolio->isMemberScope()) {
            return $actor->id == $portfolio->user_id;
        }
    }

    /**
     * Determine whether the user can create portfolios.
     *
     * @param  User  $actor
     * @return bool
     */
    public function create(User $actor)
    {
        return true;
    }

    /**
     * Determine whether the user can update the portfolio.
     *
     * @param  User  $actor
     * @param  Portfolio  $portfolio
     * @return bool
     */
    public function update(User $actor, Portfolio $portfolio)
    {
        // Admin alway has permission to update portfolios
        if ($actor->hasRole('admin')) {
            return true;
        }

        // After admin updated portfolio, user cannot edit it
        if ($portfolio->admin_updated) {
            return false;
        }

        return $portfolio->user_id == $actor->id || $actor->hasPermissionTo('update portfolios');
    }

    /**
     * Determine whether the user can delete the portfolio.
     *
     * @param  User  $actor
     * @param  Portfolio  $portfolio
     * @return bool
     */
    public function delete(User $actor, Portfolio $portfolio)
    {
        return $portfolio->user_id == $actor->id || $actor->hasPermissionTo('delete portfolios');
    }
}
