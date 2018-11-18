<?php

namespace Roan\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        return $next($request)
          ->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Headers', 'Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Request-Method')
          ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
          ->header('Allow', 'GET, POST, OPTIONS, PUT, DELETE');
    }
}
