<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoOfertasCapacitacion extends Model
{
    protected $table = 'alumno_ofertas_capacitaciones';
    protected $fillable = ['alumno_id','oferta_capacitaciones_id','apreciacion','voucher','vb','vb_apreciacion','certificado'];
}
