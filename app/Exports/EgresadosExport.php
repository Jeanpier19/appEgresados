<?php

namespace App\Exports;

use App\Egresados;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class EgresadosExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $egresados = Egresados::join('alumno', 'egresados.alumnos_id', '=', 'alumno.id')
            ->join('facultad', 'egresados.facultad_id', '=', 'facultad.id')
            ->join('escuela', 'egresados.escuela_id', '=', 'escuela.id')
            ->join('condicion', 'egresados.grado_academico', '=', 'condicion.id')
            ->select('egresados.anio', 'egresados.ciclo', 'egresados.codigo_local', 'facultad.nombre AS facultad', 'escuela.nombre AS escuela', 'alumno.codigo', 'alumno.num_documento', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', 'egresados.f_ingreso', 'egresados.f_egreso', DB::raw('UPPER(condicion.descripcion) as grado_academico'), DB::raw('UPPER(alumno.sexo) as sexo'))
            ->get();
        return view('egresadosN.export', [
            'egresados' => $egresados
        ]);
    }
}
