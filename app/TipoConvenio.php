<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoConvenio extends Model
{
    protected $table = "tipo_convenio";

    protected $fillable = ['descripcion', 'detalle'];
}
