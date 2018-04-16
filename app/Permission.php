<?php

namespace App;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    /**
     * @return array
     */
    public static function getDefaultPermissions()
    {
        return [
            'index users' => 'List all users',
            'view users' => 'Show profile of anyone users',
            'delete users' => 'Delete anyone users',
            'set permissions' => 'Update role and permissions of anyone users',

            'create news' => 'Create news',
            'index news' => 'List all news',
            'index my news' => 'List all news for me',
            'delete news' => 'Delete news',

            'create projects' => 'Allow create a normal project',
            'create prime projects' => 'Allow create a prime project',
            'index projects' => 'List all projects',
            'view projects' => 'Show detail projects of anyone',
            'update projects' => 'Update projects of anyone',
            'delete projects' => 'Delete project of anyone',

            'upload project files' => 'Upload files to any projects',
            'delete project files' => 'Remove files of any projects',

            'index my payments' => 'List all my payments',
            'index payments' => 'List all payments of all users',
            'create payment' => 'Create new payment by manual',
            'update payments' => 'Update payment of anyone',

            'index rooms' => 'List all creative rooms',
            'index my rooms' => 'List my creative rooms (owner or member)',
            'create rooms' => 'Create creative rooms',
            'update rooms' => 'Update creative rooms',

            'index portfolios' => 'List all portfolios',
            'index my portfolios' => 'List all my portfolios',
            'create portfolios' => 'Create portfolios',
            'update portfolios' => 'Update portfolios',
            'delete portfolios' => 'Delete portfolios',

            'send broadcast mail' => 'Send broadcast emails',
        ];
    }

    /**
     * @param Permission|string $permission
     * @return bool
     */
    public static function isDefaultPermission($permission): bool
    {
        $defaults = self::getDefaultPermissions();
        $guard = config('auth.defaults.guard', 'web');
        if ($permission instanceof static) {
            return $permission->guard_name === $guard && isset($defaults[$permission->name]);
        }

        return isset($defaults[$permission]);
    }
}
