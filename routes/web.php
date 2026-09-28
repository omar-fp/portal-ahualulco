<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Formulario para reportar una falla (GET) y guardar el reporte (POST)
Route::get('/reportes/crear', [ReporteController::class, 'create'])->name('reportes.create');
Route::post('/reportes', [ReporteController::class, 'store'])->name('reportes.store');

// Consultar un reporte por su folio
Route::get('/seguimiento', [ReporteController::class, 'seguimiento'])->name('seguimiento');

// Respuesta en formato JSON
Route::get('/reportes/{folio}/estado', [ReporteController::class, 'estado'])->name('reportes.estado');
