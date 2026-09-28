<?php

namespace Database\Seeders;

use App\Models\TipoReporte;
use Illuminate\Database\Seeder;

class TipoReporteSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Agua', 'Alumbrado', 'Bacheo', 'Basura'];

        foreach ($tipos as $nombre) {
            $tipo = new TipoReporte();
            $tipo->nombre = $nombre;
            $tipo->save();
        }
    }
}
