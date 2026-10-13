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

        $rol = session('user_rol');

        if (! in_array($rol, ['admin', 'recepcionista'], true)) {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado. No tienes permisos para acceder al área administrativa o de recepción.');
        }

        // Restringir configuración del sistema y gestión de usuarios exclusivamente al Administrador
        if ($rol === 'recepcionista' && ($request->is('admin/usuarios*') || $request->is('admin/horarios*'))) {
            return redirect()->route('admin.citas.index')->with('error', 'Acceso restringido. Solo el Administrador puede configurar horarios y administrar usuarios.');
        }

        return $next($request);
    }
}
