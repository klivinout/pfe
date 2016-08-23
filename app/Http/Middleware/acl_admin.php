<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class acl_admin
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
        if(Auth::User()->type == 10)
            return $next($request);
        else
            return redirect()->route('logout')->with('info','tralala');
    }
}
