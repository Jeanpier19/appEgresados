<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'convenios';

    protected $fillable = [
        'nombre', 'resolucion', 'objetivo', 'obligaciones', 'fecha_inicio', 'fecha_vencimiento', 'dias_restantes', 'documento', 'vigencia', 'estado', 'activo', 'usuario_creacion', 'usuario_modificacion', 'entidad_id', 'tipo_convenio_id'
    ];
}
