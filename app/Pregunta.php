<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = [
        'titulo', 'descripcion', 'tipo', 'indicador', 'interpretacion', 'activo', 'opciones', 'user_created','user_updated'
    ];
}
