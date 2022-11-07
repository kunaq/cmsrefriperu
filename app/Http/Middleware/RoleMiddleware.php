<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        if($request->session()->exists('usuario') && RoleHelper::hasAnyRole($roles)){
            
            return $next($request);

        }else{
        	return redirect('home');
        }

    }
}
