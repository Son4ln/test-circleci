<?php

namespace App\Policies;

use App\User;
use App\Info;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list all users.
     *
     * @param User $actor
     * @return boolean
     */
    public function index(User $actor)
    {
        return $actor->hasPermissionTo('index news');
    }

    /**
     * Determine whether the user can view the info.
     *
     * @param  \App\User  $actor
     * @param  \App\Info  $info
     * @return mixed
     */
    public function view(User $actor, Info $info)
    {
        return $actor->hasAnyPermission(['index news', 'index my news']);
    }

    /**
     * Determine whether the user can create infos.
     *
     * @param  \App\User  $actor
     * @return mixed
     */
    public function create(User $actor)
    {
        return $actor->hasPermissionTo('create news');
    }

    /**
     * Determine whether the user can update the info.
     *
     * @param  \App\User  $actor
     * @param  \App\Info  $info
     * @return mixed
     */
    public function update(User $actor, Info $info)
    {
        // Disallow edit news
        return false;
    }

    /**
     * Determine whether the user can delete the info.
     *
     * @param  \App\User  $actor
     * @param  \App\Info  $info
     * @return mixed
     */
    public function delete(User $actor, Info $info)
    {
        return $actor->hasPermissionTo('delete news');
    }
}
