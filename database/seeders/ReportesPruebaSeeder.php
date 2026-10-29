<?php
namespace Database\Seeders;

use App\Models\Reporte;
use Illuminate\Database\Seeder;

class ReportesPruebaSeeder extends Seeder {
    public function run(): void {
        Reporte::factory()->count(35)->create();
    }
}