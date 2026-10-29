<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'tipo_reporte_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Un administrador de área pertenece a un tipo de reporte
    public function tipoReporte()
    {
        return $this->belongsTo(TipoReporte::class, 'tipo_reporte_id');
    }

    // Indica si es el administrador general (ve todos los reportes)
    public function esSuper()
    {
        return $this->rol == 'super';
    }
}
