<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfertasCapacitaciones extends Model
{
    protected $tabla = 'ofertas_capacitaciones';
    protected $fillable = ['entidad_id','curso_id','imagen','oferta_descripcion','vb','precio','total_alumnos','recomendacion','fecha_inicio','fecha_fin','imagen_evidencia'];
}
