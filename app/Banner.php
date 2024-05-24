<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Temporal;

class Banner extends Model
{
    protected $fillable = ['id','nombre', 'imagen', 'fecha_fin', 'tempo_id'];

    public function temporal()
    {
        return $this->belongsTo(Temporal::class, 'tempo_id');
    }
}
