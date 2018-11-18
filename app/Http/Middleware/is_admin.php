<?php

namespace Roan\Http\Middleware;

use Closure;

class is_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        /*
            if(req.user.role != 'ROLE_ADMIN'){
                return res.status(200).send({message: 'No tienes acceso aesta zona'});
            }
        */
        if (\Auth::user()->role == 'ROLE_ADMIN') {
            return $next($request);
        }

      return redirect('home');
    }
}
