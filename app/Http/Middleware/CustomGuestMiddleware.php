<?php

namespace App\Http\Middleware;

use Closure;

class CustomGuestMiddleware
{
    public function handle($request, Closure $next)
    {
        if($request->session()->exists('usuario'))
            return redirect('home');

        return $next($request);
    }
}
