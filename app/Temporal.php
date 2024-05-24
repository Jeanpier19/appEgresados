<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Banner;

class Temporal extends Model
{
    protected $fillable = ['tempo'];

    public function banners()
    {
        return $this->hasMany(Banner::class, 'id');
    }
}
