<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAutenticado
{
    /**
     * Handle an incoming request.RedirectIfAutenticado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->session()->exists('usuario') && $request->session()->exists('numeruc')){  //$request->session()->has('usuario') && $request->session()->has('numeruc') 
            return redirect('/home');    
        }

        return $next($request);
    }
}
