<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;

use Closure;

class AutenticadoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    
    public function handle($request, Closure $next){   //Hago la validacion del usuario autenticado
                    
        if($request->session()->exists('usuario') && $request->session()->exists('numeruc')){  //$request->session()->has('usuario') && $request->session()->has('numeruc')
            return $next($request);
        }

        return redirect('/');

    }
}
