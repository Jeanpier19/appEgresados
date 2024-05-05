<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuesta';

    protected $fillable = [
        'titulo', 'descripcion', 'interpretacion', 'fecha_apertura', 'fecha_vence', 'fecha_extension', 'documento', 'estado', 'usuario_creacion', 'usuario_modificacion'
    ];

    public function preguntas()
    {
        return $this->belongsToMany(Pregunta::class);
    }
}
