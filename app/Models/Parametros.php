<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    protected $table = 'parametros';

    protected $fillable = ['codigo', 'descripcion', 'valor', 'activo'];

}
