<?php

namespace App\Http\Middleware;

use Closure;

class acl_ms
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
        //access controle for "maitre de stage"
        if(Auth::User()->type != 2)
            return $next($request);
        else
            return redirect()->route('logout')->with('info','tralala');
    }
}
