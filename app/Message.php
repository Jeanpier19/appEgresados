<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'nombre', 'correo', 'telefono', 'mensaje'
    ];
}
