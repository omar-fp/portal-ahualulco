<?php

use App\Http\Controllers\Admin\AdministradorController;
use App\Http\Controllers\Admin\ReporteAdminController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UbicacionController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Historia y ubicación del municipio
Route::get('/historia', [HistoriaController::class, 'index'])->name('historia');
Route::get('/ubicacion', [UbicacionController::class, 'index'])->name('ubicacion');

// Formulario para reportar una falla y guardar el reporte 
Route::get('/reportes/crear', [ReporteController::class, 'create'])->name('reportes.create');

// middleware para no permitir enviar dos reportes seguidos muy rápido
Route::post('/reportes', [ReporteController::class, 'store'])
    ->middleware('limitar.reportes')
    ->name('reportes.store');

// Consultar un reporte por su folio
Route::get('/seguimiento', [ReporteController::class, 'seguimiento'])->name('seguimiento');

// Respuesta en formato JSON
Route::get('/reportes/{folio}/estado', [ReporteController::class, 'estado'])->name('reportes.estado');




// ---------- Acceso de administradores ----------
// No hay ningún enlace público a /login: se entra escribiendo la dirección.
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    // máximo 5 intentos por minuto para frenar la adivinación de contraseñas
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// ---------- Panel----------
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Admin general y admin de área (cada uno ve lo que le corresponde)
    Route::get('/reportes', [ReporteAdminController::class, 'index'])->name('reportes.index');
    Route::patch('/reportes/{reporte}/estado', [ReporteAdminController::class, 'actualizarEstado'])->name('reportes.estado');

    // Solo el administrador general
    Route::middleware('super')->group(function () {
        Route::delete('/reportes/{reporte}', [ReporteAdminController::class, 'destroy'])->name('reportes.destroy');
        Route::get('/administradores', [AdministradorController::class, 'index'])->name('administradores.index');
        Route::get('/administradores/crear', [AdministradorController::class, 'create'])->name('administradores.create');
        Route::post('/administradores', [AdministradorController::class, 'store'])->name('administradores.store');
    });
});
