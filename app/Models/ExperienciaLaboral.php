<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    protected $table = 'experiencia_laboral';

    protected $fillable = ['alumno_id', 'entidad_id', 'fecha_inicio', 'fecha_salida', 'cargo_laboral', 'cargo', 'reconocimientos', 'nivel_satisfaccion', 'oferta_id', 'estado', 'archivo', 'vb'];

}
