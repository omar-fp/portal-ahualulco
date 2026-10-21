<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'limitar.reportes' => \App\Http\Middleware\LimitarReportes::class,
            'super'            => \App\Http\Middleware\SoloSuperAdmin::class,
        ]);
        $middleware->redirectUsersTo(fn () => route('admin.reportes.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
