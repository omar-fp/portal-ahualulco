<?php

namespace Database\Seeders;

use App\Models\Colonia;
use Illuminate\Database\Seeder;

class ColoniasSeeder extends Seeder
{
    public function run(): void
    {
        $colonias = [
            '5 de Mayo',
            'Centro',
            'Ejidal',
            'Arboledas',
            'Emiliano Zapata',
            'Fausto Quintero',
            'Jardines',
            'Floresta',
            'Huerta',
            'Primavera',
            'Mesitas',
            'Libertad',
            'Ayahualulco',
            'Aguacates',
            'Cascos',
            'Mezquites',
            'Providencia'
        ];

        foreach ($colonias as $valor) {
            $colonia = new Colonia();
            $colonia->colonias = $valor;
            $colonia->save();
        }
    }
}