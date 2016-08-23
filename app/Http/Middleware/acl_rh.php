<?php

namespace App\Http\Middleware;

use Closure;

class acl_rh
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
        //Access Control for "Ressource humaines"
        if(Auth::User()->type != 1)
            return $next($request);
        else
            return redirect()->route('logout')->with('info','tralala');
    }
}
