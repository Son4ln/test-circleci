<?php

namespace App;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    /**
     * @return array
     */
    public static function getDefaultRoles()
    {
        return [
            'creator' => [
                'index users',
                'index my news',
                'index projects',
                'index my payments',
                'index rooms',
                'index my rooms',
                'create rooms',
                'index portfolios',
                'index my portfolios',
                'create portfolios',
            ],
            'client' => [
                'create projects',
                'index users',
                'index my news',
                'index projects',
                'index my payments',
                'index rooms',
                'index my rooms',
                'create rooms',
                'index portfolios',
                'index my portfolios',
                'create portfolios',
            ],
            'admin' => [
                'index users',
                'view users',
                'delete users',
                'set permissions',
                'create news',
                'index news',
                'index my news',
                'delete news',
                'create projects',
                'create prime projects',
                'index projects',
                'view projects',
                'update projects',
                'delete projects',
                'upload project files',
                'delete project files',
                'index my payments',
                'index payments',
                'create payment',
                'update payments',
                'index rooms',
                'index my rooms',
                'create rooms',
                'update rooms',
                'index portfolios',
                'index my portfolios',
                'create portfolios',
                'update portfolios',
                'delete portfolios',
                'send broadcast mail',
            ],
            'c-operation-client' => [
                'create prime projects',
            ],
            'cert-creator' => [
                //
            ],
        ];
    }

    /**
     * @param Role|string $role
     * @return bool
     */
    public static function isDefaultRole($role): bool
    {
        $defaults = self::getDefaultRoles();
        $guard = config('auth.defaults.guard', 'web');
        if ($role instanceof static) {
            return $role->guard_name === $guard && isset($defaults[$role->name]);
        }

        return isset($defaults[$role]);
    }
}
