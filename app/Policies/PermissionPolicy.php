<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can listing permissions.
     *
     * @param User $actor
     * @return bool
     */
    public function index(User $actor)
    {
        return $actor->can('set permissions');
    }

    /**
     * Determine whether the user can view the permission.
     *
     * @param User $actor
     * @param Permission $permission
     * @return bool
     */
    public function view(User $actor, Permission $permission)
    {
        return $actor->can('set permissions');
    }

    /**
     * Determine whether the user can create a permission.
     *
     * @param  User $actor
     * @return bool
     */
    public function create(User $actor)
    {
        // Only add permission by programmer
        return false;
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param User $actor
     * @param Permission $permission
     * @return bool
     */
    public function update(User $actor, Permission $permission)
    {
        return $actor->can('set permissions');
    }


    /**
     * Determine whether the user can delete the permission.
     *
     * @param  User $actor
     * @param  Permission $permission
     * @return bool
     */
    public function delete(User $actor, Permission $permission)
    {
        // Only remove permission by programmer
        return false;
    }
}
