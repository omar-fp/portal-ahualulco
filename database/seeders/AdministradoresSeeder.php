<?php

namespace Database\Seeders;

use App\Models\TipoReporte;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdministradoresSeeder extends Seeder {
    public function run(): void {
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            $this->command->error('Falta ADMIN_PASSWORD en el archivo .env');
            return;
        }

        User::updateOrCreate(
            ['email' => 'admin@ahualulco.test'],
            ['name' => 'Administrador general', 'password' => $password, 'rol' => 'super', 'tipo_reporte_id' => null]
        );

        foreach (TipoReporte::all() as $tipo) {
            User::updateOrCreate(
                ['email' => Str::slug($tipo->nombre) . '@ahualulco.test'],
                ['name' => 'Administrador de ' . $tipo->nombre, 'password' => $password, 'rol' => 'area', 'tipo_reporte_id' => $tipo->id]
            );
        }
    }
}
