<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $table = "facultad";

    protected $fillable = ['nombre', 'logo'];

}
