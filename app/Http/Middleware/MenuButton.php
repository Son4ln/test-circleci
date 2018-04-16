<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class MenuButton
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
        $action = $request->route()->getAction();
        if(isset($action["as"])){
            $action = $action["as"];
        }else{
            $action = $action["uses"];
        }
        $creativeroom = array("creative-rooms.create","creative-rooms.index");
        $client = array("projects.create","projects.clients","payments.index","creators.index","portfolios.index");
        $creator = array("projects.index","proposals.index","rewords.index","portfolios.create","portofolios.index","App\Http\Controllers\PortfoliosController@meApp\Http\Controllers\PortfoliosController@me");
        $prime = array("prime-projects.desc","prime-projects.create","prime-projects.index","App\Http\Controllers\PrimeProjectsController@facebookCert","analyze.index","alerts.index");

        $submenu_actived = array("creativeroom"=>"","client"=>"","creator"=>"","prime"=>"");

        $menu_open_class = "menu-open active";
        if(in_array($action, $creativeroom)){
            $submenu_actived["creativeroom"] = $menu_open_class;
        }
        if(in_array($action, $client)){
            $submenu_actived["client"] = $menu_open_class;
        }
        if(in_array($action, $creator)){
            $submenu_actived["creator"] = $menu_open_class;
        }
        if(in_array($action, $prime)){
            $submenu_actived["prime"] = $menu_open_class;
        }

        View::share("submenu_actived", $submenu_actived);

        return $next($request);
    }
}
