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
        if(Auth::User()->type != 1)
            return redirect()->back()->with('danger','Vous n\'avez pas le droit d\'access !!');
        return $next($request);
    }
}
