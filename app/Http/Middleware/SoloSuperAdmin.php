<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SoloSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->esSuper()) {
            return redirect()->route('admin.reportes.index')
                ->with('error', 'No tienes permiso para entrar a esa sección.');
        }
        return $next($request);
    }
}
