<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $actor->hasAnyPermission([
            'index users',
            'set permissions',
        ]);
    }

    /**
     * Determine whether the user can list all creators.
     *
     * @param User $actor
     * @return boolean
     */
    public function list(User $actor)
    {
        return $actor->hasAnyPermission([
            'index users',
            'set permissions',
        ]);
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  User  $actor
     * @param  User  $user
     * @return mixed
     */
    public function view(User $actor, User $user)
    {
        if (!$user->isEnabled()) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  User  $actor
     * @return mixed
     */
    public function create(User $actor)
    {
        // Only allow user register account
        return false;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  User  $actor
     * @param  User  $user
     * @return bool
     */
    public function update(User $actor, User $user)
    {
        return ($actor->id == $user->id);
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  User  $actor
     * @param  User  $user
     * @return bool
     */
    public function delete(User $actor, User $user)
    {
        return ($actor->id == $user->id) || $actor->hasPermissionTo('delete users');
    }

    /**
     * Determine whether the user can update roles of the user.
     *
     * @param  User  $actor
     * @param  User  $user
     * @return bool
     */
    public function updateRoles(User $actor, User $user)
    {
        return $actor->hasPermissionTo('set permissions');
        //return ($actor->id != $user->id) && $actor->hasPermissionTo('set permissions');
    }

    /**
     * Determine whether the user can update permissions of the user.
     *
     * @param  User  $actor
     * @param  User  $user
     * @return bool
     */
    public function updatePermissions(User $actor, User $user)
    {
        return $actor->hasPermissionTo('set permissions');
        //return ($actor->id != $user->id) && $actor->hasPermissionTo('set permissions');
    }

    public function activeCreator(User $actor)
    {
        return $actor->hasRole('admin');
    }
}
