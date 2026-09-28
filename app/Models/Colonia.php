<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'colonia_id');
    }
}
