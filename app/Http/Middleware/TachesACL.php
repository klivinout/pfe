<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class TachesACL
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
        if(Auth::User()->type ==3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        return $next($request);
    }
}
