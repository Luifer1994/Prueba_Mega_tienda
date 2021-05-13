<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRole extends Model
{
    use HasFactory;
    protected $table = "usuario_roles";
    protected $fillable= [
        'cod_usuario',
        'cod_rol',
    ];
}
