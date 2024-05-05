<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = "alumno";

    protected $fillable = ['codigo', 'paterno', 'materno', 'nombres', 'tipo_documento', 'num_documento', 'direccion', 'correo', 'telefono', 'celular', 'activo', 'estado', 'sexo', 'user_id'];
}
