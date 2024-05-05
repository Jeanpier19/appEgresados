<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mencion extends Model
{
    protected $table = 'menciones';

    protected $fillable = ['nombre', 'maestria_id'];
}
