<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('api_token')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión primero');
        }

        return $next($request);
    }
}