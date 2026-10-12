<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LimitarReportes
{
    public function handle(Request $request, Closure $next)
    {
        $ultimoEnvio = session('ultimo_envio_reporte');

        if ($ultimoEnvio && $ultimoEnvio->diffInSeconds(now()) < 60) {
            return redirect()->route('reportes.create')
                ->with('error', 'Ya enviaste un reporte hace unos segundos. Espera un minuto antes de enviar otro.');
        }

        $respuesta = $next($request);

        if ($respuesta->isRedirect() && session('exito')) {
            session(['ultimo_envio_reporte' => now()]);
        }

        return $respuesta;
    }
}
