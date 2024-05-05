<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestre';

    protected $fillable = ['descripcion', 'fecha_inicio', 'fecha_fin', 'anio', 'activo'];
}
