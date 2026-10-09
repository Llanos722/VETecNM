<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'acceso_denegado');
        }

        if (session('user_rol') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado. Solo los administradores pueden acceder a esta sección.');
        }

        return $next($request);
    }
}
