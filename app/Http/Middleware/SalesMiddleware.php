<?php

namespace App\Http\Middleware;

use Closure;

class SalesMiddleware
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
        if ($request->user() && $request->user()->role_type === 2){
            return Response(view('unauthorized')->with('role', 'ADMIN'));
        }
        return $next($request);
    }
}
