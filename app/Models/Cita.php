<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table = "citas";
    protected $fillable= [
        'descripcion',
        'cupos_totales',
        'cupos_disponibles',
        'copos_disponibles',
        'cod_usuario_prestador',
        'fecha',
    ];
}
