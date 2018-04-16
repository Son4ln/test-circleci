<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\FlashMessage\Facades\Flash;

class CheckRole
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('admin')) {
            return $next($request);
        }

        if($role == 'creator' && $user->is_creator == User::CREATOR_REGISTING && $user->hasRole('creator')) {
            return response(view('users.upgrade.pending'));
        }

        if (!$user->hasAnyRole([$role])) {
            $msg = $this->getUpgradeAccountMsg($role);
            if ($msg) {
//                Flash::warning($msg)->important();
            }

            return redirect($this->getUpgradeAccountUrl($role));
        }

        return $next($request);
    }

    /**
     * @param string $role
     * @return string
     */
    protected function getUpgradeAccountUrl($role)
    {
        $availableUrl = [
            'client' => '/upgrade/client',
            'creator' => '/upgrade/creator',
            'c-operation-client' => '/plans',
        ];

        return $availableUrl[$role] ?? '/';
    }

    /**
     * @param string $role
     * @return string|null
     */
    protected function getUpgradeAccountMsg($role)
    {
        $availableUrl = [
            'c-operation-client' => __('flash_messages.prime_projects.register_c_operation'),
        ];

        return $availableUrl[$role] ?? null;
    }
}
