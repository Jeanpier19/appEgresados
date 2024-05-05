<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacitaciones extends Model
{
    protected $table = 'capacitaciones';
    protected $primaryKey = 'id';

    protected $fillable = ['curso_id', 'alumno_id', 'descripcion', 'fecha_inicio', 'fecha_fin', 'archivo','estado', 'activo', 'vb'];

}
