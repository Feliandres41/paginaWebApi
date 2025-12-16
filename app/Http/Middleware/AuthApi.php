<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthApi
{
    /**
     * Manejar la solicitud para verificar que el token esté presente en la sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el token existe en la sesión
        if (!session()->has('api_token')) {
            // Si no hay token, redirige al login
            return redirect()->route('login');
        }

        // Si hay token, continuar con la solicitud
        return $next($request);
    }
}
