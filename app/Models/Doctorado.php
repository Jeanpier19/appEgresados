<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctorado extends Model
{
    protected $table = 'doctorados';
    protected $fillable = ['nombre', 'activo'];
}
