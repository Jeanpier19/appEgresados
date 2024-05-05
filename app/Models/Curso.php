<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'curso';

    protected $fillable = ['entidad_id', 'titulo', 'descripcion', 'creditos', 'horas', 'idarea'];
}
