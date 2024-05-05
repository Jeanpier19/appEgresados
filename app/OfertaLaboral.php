<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfertaLaboral extends Model
{
    protected $table = 'ofertas_laborales';

    protected $fillable = ['titulo', 'perfil', 'area', 'fecha_publicacion', 'fecha_vencimiento', 'jornada', 'salario', 'vacantes', 'fecha_contratacion', 'documento', 'estado','alumno_id', 'entidad_id', 'tipo_contrato_id', 'usuario_creacion', 'usuario_modificacion'];
}
