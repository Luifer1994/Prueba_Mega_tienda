<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTipoUsuario extends Model
{
    use HasFactory;
    protected $table = "usuario_tipo_usuarios";
    protected $fillable= [
        'cod_usuario',
        'cod_tipo_usuario',
    ];

}
