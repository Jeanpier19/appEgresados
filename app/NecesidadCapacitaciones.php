<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NecesidadCapacitaciones extends Model
{
    protected $table = 'necesidad_capacitaciones';
    protected $fillable = ['alumno_id','descripcion','fecha','horas','comentarios','precio'];
}
