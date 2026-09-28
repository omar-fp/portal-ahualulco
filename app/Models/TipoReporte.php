<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoReporte extends Model
{
    protected $table = 'tipo_reportes';

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'tipo_reporte_id');
    }
}
