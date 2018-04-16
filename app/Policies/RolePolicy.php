<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can listing roles.
     *
     * @param User $actor
     * @return bool
     */
    public function index(User $actor)
    {
        return $actor->can('set permissions');
    }

    /**
     * Determine whether the user can show the role.
     *
     * @param User $actor
     * @param Role $role
     * @return bool
     */
    public function view(User $actor, Role $role)
    {
        return $actor->can('set permissions');
    }

    /**
     * Determine whether the user can create a role.
     *
     * @param User $actor
     * @return bool
     */
    public function create(User $actor)
    {
        return $actor->can('set permissions');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param User $actor
     * @param Role $role
     * @return bool
     */
    public function update(User $actor, Role $role)
    {
        return $actor->can('set permissions');
        //return !Role::isDefaultRole($role) && $actor->can('set permissions');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param User $actor
     * @param Role $role
     * @return bool
     */
    public function delete(User $actor, Role $role)
    {
        return !Role::isDefaultRole($role) &&  $actor->can('set permissions');
    }
}
