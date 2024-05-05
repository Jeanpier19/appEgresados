<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoOfertaLaboral extends Model
{
    protected $table = 'alumno_oferta_laboral';

    protected $fillable = ['alumno_id', 'oferta_laboral_id'];
}
