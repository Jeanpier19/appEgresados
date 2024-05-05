<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tablas extends Model
{
    protected $table = 'tablas';

    protected $fillable = ['valor', 'dep_id', 'descripcion', 'estado', 'abreviatura'];

}
