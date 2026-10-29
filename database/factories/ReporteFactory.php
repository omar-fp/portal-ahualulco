<?php

namespace Database\Factories;

use App\Models\Colonia;
use App\Models\Reporte;
use App\Models\TipoReporte;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReporteFactory extends Factory {
    protected $model = Reporte::class;

    public function definition(): array {
        $fecha = fake()->dateTimeBetween('-30 days', 'now');

        return [
            'folio'            => Reporte::generarFolio(),
            'tipo_reporte_id'  => TipoReporte::inRandomOrder()->value('id'),
            'nombre_ciudadano' => fake()->name(),
            'calle'            => fake()->streetName(),
            'colonia_id'       => Colonia::inRandomOrder()->value('id'),
            'descripcion'      => fake()->randomElement([
                'Hay una fuga de agua en la banqueta desde hace varios días.',
                'La luminaria de la esquina no enciende por las noches.',
                'Hay un bache grande que dificulta el paso de los vehículos.',
                'La basura no se ha recogido en toda la semana.',
                'Llevamos dos días sin servicio de agua en esta calle.',
                'Varias lámparas de la calle están apagadas y hay poca visibilidad.',
            ]),
            'estado'           => fake()->randomElement(['pendiente', 'en_proceso', 'atendido']),
            'created_at'       => $fecha,
            'updated_at'       => $fecha,
        ];
    }
}
