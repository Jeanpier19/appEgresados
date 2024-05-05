<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    protected $table = 'escuela';

    protected $fillable = ['facultad_id', 'nombre', 'logo', 'activo'];

}
