<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoEncuestaDetalle extends Model
{
    protected $table = 'alumno_encuesta_detalle';

    protected $fillable = [
        'respuesta', 'otro', 'alumno_encuesta_id', 'pregunta_id', 'usuario_creacion', 'usuario_modificacion'
    ];
}
