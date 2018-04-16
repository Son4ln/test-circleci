<?php

namespace App\Http\Traits;

trait AuthenticatedRedirects
{
    /**
     * @return string
     */
    public function redirectTo()
    {
//        $user = $this->guard()->user();
//
//        if (!$user) {
//            // Not authenticated
//            return '/';
//        }

        return '/';
    }
}
