<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Guardar la URL a la que el usuario quería ir
            session(['url.intended' => $request->url()]);
            
            // Redireccionar al login con un mensaje
            session()->flash('auth_required', 'Debes iniciar sesión para acceder a esta funcionalidad.');
            
            return redirect()->route('login');
        }

        return $next($request);
    }
}
