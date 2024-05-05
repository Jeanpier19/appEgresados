<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    protected $table = 'condicion';

    protected $fillable = ['descripcion','usuario_creacion','usuario_modificacion','created_at','updated_at'];
}
