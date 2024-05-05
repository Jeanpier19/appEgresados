<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoEncuesta extends Model
{
    protected $table = 'alumno_encuesta';

    protected $fillable = [
        'fecha_llenado', 'encuesta_id', 'alumno_id', 'usuario_creacion', 'usuario_modificacion'
    ];
}
