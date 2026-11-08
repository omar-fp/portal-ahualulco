<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reporte extends Model {
    use HasFactory;

    protected function casts(): array {
        return [
            'atendido_en' => 'date',
        ];
    }

    // El comprobante PDF solo existe cuando el reporte ya fue atendido y tiene su causa y su fecha
    public function tieneComprobante() {
        return $this->estado == 'atendido' && $this->causa != null && $this->atendido_en != null;
    }

    // Genera un folio de 8 caracteres que no exista en la base de datos
    public static function generarFolio() {
        $folio = strtoupper(Str::random(8));

        while (Reporte::where('folio', $folio)->exists()) {
            $folio = strtoupper(Str::random(8));
        }

        return $folio;
    }

    // Convierte el estado guardado en la BD a un texto para mostrar
    public function nombreEstado() {
        if ($this->estado == 'en_proceso') {
            return 'En proceso';
        }
        if ($this->estado == 'atendido') {
            return 'Atendido';
        }
        return 'Pendiente';
    }

    // Un reporte pertenece a un tipo de reporte
    public function tipo() {
        return $this->belongsTo(TipoReporte::class, 'tipo_reporte_id');
    }

    // Un reporte pertenece a una colonia
    public function colonia() {
        return $this->belongsTo(Colonia::class, 'colonia_id');
    }
}