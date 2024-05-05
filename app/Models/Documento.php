<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = ['file', 'tipo_documento', 'descripcion', 'fecha_envio','respuesta'];

}
