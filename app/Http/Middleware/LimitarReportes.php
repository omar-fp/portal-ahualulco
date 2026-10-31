<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LimitarReportes {
    public function handle(Request $request, Closure $next) {
        $clave = 'reporte-ip:' . $request->ip();

        if (RateLimiter::tooManyAttempts($clave, 1)) {
            $segundos = RateLimiter::availableIn($clave);

            return redirect()->route('reportes.create')
                ->with('error', 'Ya enviaste un reporte hace unos segundos. Espera ' . $segundos . ' segundos antes de enviar otro.');
        }

        $respuesta = $next($request);
        if ($respuesta->isRedirect() && session('exito')) {
            RateLimiter::hit($clave, 60);
        }

        return $respuesta;
    }
}