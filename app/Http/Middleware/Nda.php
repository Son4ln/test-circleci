<?php

namespace App\Http\Middleware;
use Closure;

class Nda
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

        if (preg_match('/disp/',$request->url())){
            $projects = explode(',', session('nda_project'));
            $searched = array_search($request->input('id'), $projects);
            if (!$request->input('nda') && !$searched && auth()->user()->kind == 1)
            {
                session(['nda' => $request->input('id')]);
                return redirect('nda')->withInput();
            }else{
                if(!$searched){
                    session(['nda_project' => session('nda_project').','.$request->input('id')]);
                }
            }
        }
        return $next($request);
    }
}
