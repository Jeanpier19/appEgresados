<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';

    protected $fillable = ['tipo', 'sector', 'nombre', 'correo', 'telefono', 'celular', 'logo', 'activo'];
}
