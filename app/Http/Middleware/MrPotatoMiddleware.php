<?php

namespace App\Http\Middleware;

use Closure;

class MrPotatoMiddleware
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

        if($request->user() && $request->user()->role_type === 6){  
            return Response(view('unauthorized')->with('role', 'ADMIN'));
        }
        
        return $next($request);
    }
}
