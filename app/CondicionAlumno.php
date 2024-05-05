<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CondicionAlumno extends Model
{
    protected $table = 'condicion_alumnos';
    protected $fillable = ['alumno_id', 'condicion_id', 'codigo_local', 'escuela_id', 'maestria_id','mencion_id', 'doctorado_id', 'semestre_ingreso', 'semestre_egreso', 'anio', 'fecha', 'resolucion', 'usuario_creacion', 'usuario_modificacion', 'created_at', 'updated_at'];
}
