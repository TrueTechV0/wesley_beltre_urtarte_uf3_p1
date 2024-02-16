<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si la solicitud tiene un campo 'url' enviado a través de POST
        if ($request->has('url')) {
            $url = $request->input('url');

            // Verificar si la URL es válida
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                // Si la URL no es válida, mostrar un mensaje de error en la vista de bienvenida
                return response(view('welcome', ["Error" => "Sorry, but this is not a valid URL."]));
            }
        }

        // Si la URL es válida o no se ha enviado, continuar con la solicitud
        return $next($request);
    }
}
