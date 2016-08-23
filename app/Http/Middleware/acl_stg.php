<?php

namespace App\Http\Middleware;

use Closure;

class acl_stg
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
        if(Auth::User()->type != 3)
            return $next($request);
        else
            return redirect()->route('logout')->with('info','tralala');
    }
}
