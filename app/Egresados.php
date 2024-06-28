<?php

namespace App;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Model;

class Egresados extends Model
{
    protected $table = 'egresados';
    protected $fillable = ['id', 'anio', 'ciclo', 'codigo_local', 'facultad_id', 'escuela_id', 'alumnos_id', 'f_ingreso', 'f_egreso', 'grado_academico'];
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
