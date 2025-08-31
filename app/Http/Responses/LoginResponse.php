<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): Response
    {
        // Verificar si hay un parámetro redirect en la request
        if ($request->has('redirect')) {
            $redirectUrl = urldecode($request->get('redirect'));
            return redirect($redirectUrl);
        }

        // Si hay una URL de redirección guardada en sesión, usar esa URL
        if (session()->has('url.intended')) {
            $intended = session()->get('url.intended');
            session()->forget('url.intended');
            return redirect($intended);
        }

        // Si no, redireccionar al dashboard por defecto
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended(config('fortify.home', '/dashboard'));
    }
}
