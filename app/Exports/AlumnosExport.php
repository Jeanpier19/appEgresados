<?php

namespace App\Exports;

use App\CondicionAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class AlumnosExport implements FromView, ShouldAutoSize
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $alumnos = CondicionAlumno::join('alumno', 'condicion_alumnos.alumno_id', '=', 'alumno.id')
            ->join('escuela', 'condicion_alumnos.escuela_id', '=', 'escuela.id')
            ->join('condicion', 'condicion_alumnos.condicion_id', '=', 'condicion.id')
            ->select('escuela.nombre as escuela', 'alumno.codigo', 'alumno.num_documento', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', DB::raw('UPPER(condicion.descripcion) as grado_academico'), DB::raw('UPPER(alumno.sexo) as sexo'));
            if ($this->request->has('escuela_id') && $this->request->escuela_id !== '') {
                $alumnos->where('escuela.id', '=', $this->request->escuela_id);
            }
            
            if ($this->request->has('condicion_id') && $this->request->condicion_id !== '') {
                $alumnos->where('condicion.id', '=', $this->request->condicion_id);
            }
            $alumnos = $alumnos->get();
        return view('Alumnos.export', [
            'alumnos' => $alumnos
        ]);
    }
}
