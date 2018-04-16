<?php

namespace App\Http\Middleware;

use Closure;

class DebugBarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*if(\Auth::check() && \Auth::user()->email == env('DEBUGBAR_EMAIL', '')) {
            \Debugbar::enable();
        }else{
            \Debugbar::disable();
        }*/

        return $next($request);
    }
}
