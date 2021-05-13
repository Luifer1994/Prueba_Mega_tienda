<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupo extends Model
{
    use HasFactory;
    protected $table = "cupos";
    protected $fillable= [
        'cod_cita',
        'cod_usuario_solicitante',
    ];

}
