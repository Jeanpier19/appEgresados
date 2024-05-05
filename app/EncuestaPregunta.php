<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncuestaPregunta extends Model
{
    protected $table = 'encuesta_pregunta';

    protected $fillable = [
        'grupo', 'nombre_grupo', 'interpretacion', 'encuesta_id', 'pregunta_id'
    ];
}
