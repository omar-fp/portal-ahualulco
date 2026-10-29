<?php

namespace App\Console\Commands;

use App\Models\Reporte;
use Illuminate\Console\Command;

class ResumenReportes extends Command {
    protected $signature = 'reportes:resumen';

    protected $description = 'Muestra cuántos reportes hay en total y por estado';

    public function handle() {
        // Collection con todos los reportes
        $reportes = Reporte::all();

        $this->info('Total de reportes: ' . $reportes->count());
        $this->info('Pendientes: ' . $reportes->where('estado', 'pendiente')->count());
        $this->info('En proceso: ' . $reportes->where('estado', 'en_proceso')->count());
        $this->info('Atendidos: ' . $reportes->where('estado', 'atendido')->count());

        return 0;
    }
}