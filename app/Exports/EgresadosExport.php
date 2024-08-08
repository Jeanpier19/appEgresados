<?php

namespace App\Exports;

use App\Egresados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EgresadosExport implements FromView, ShouldAutoSize, WithChunkReading, WithBatchInserts
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
        $egresados = Egresados::join('alumno', 'egresados.alumnos_id', '=', 'alumno.id')
            ->join('facultad', 'egresados.facultad_id', '=', 'facultad.id')
            ->join('escuela', 'egresados.escuela_id', '=', 'escuela.id')
            ->join('condicion', 'egresados.grado_academico', '=', 'condicion.id')
            ->select('egresados.anio', 'egresados.ciclo', 'egresados.codigo_local', 'facultad.nombre AS facultad', 'escuela.nombre AS escuela', 'alumno.codigo', 'alumno.num_documento', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', 'egresados.f_ingreso', 'egresados.f_egreso', DB::raw('UPPER(condicion.descripcion) as grado_academico'), DB::raw('UPPER(alumno.sexo) as sexo'));

        if ($this->request->has('escuela_id') && $this->request->escuela_id !== '') {
            $egresados->where('escuela.id', '=', $this->request->escuela_id);
        }
        
        if ($this->request->has('condicion_id') && $this->request->condicion_id !== '') {
            $egresados->where('condicion.id', '=', $this->request->condicion_id);
        }

        if ($this->request->has('semestre_id') && $this->request->input('semestre_id') !== '') {
            $egresados->where('egresados.f_egreso', '=', $this->request->input('semestre_id'));
        }

        return view('egresadosN.export', [
            'egresados' => $egresados->cursor() // Usa cursor() para manejar grandes volúmenes de datos eficientemente
        ]);
    }

    public function batchSize(): int
    {
        return 1000; // Número de registros por bloque
    }

    public function chunkSize(): int
    {
        return 1000; // Número de registros por lote
    }
}
