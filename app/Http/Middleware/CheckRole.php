<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
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
        if ( !Auth::check() )
            return redirect('login');

        if (Auth::user()->role == 1 or Auth::user()->role == 2)
            return $next($request);
        
        return redirect('unlegitimate');    
    }
}
