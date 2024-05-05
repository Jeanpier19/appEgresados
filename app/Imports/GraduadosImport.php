<?php

namespace App\Imports;

use App\CondicionAlumno;
use App\Models\Alumno;
use App\Models\Escuela;
use App\Models\Tablas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GraduadosImport implements ToCollection, WithHeadingRow, SkipsOnFailure, WithChunkReading, WithBatchInserts
{
    use Importable, SkipsFailures;

    private $row_validate;

    private $errors = [];

    public function headingRow(): int
    {
        return 3;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();
        foreach ($rows as $index => $row) {
            if (isset($row['apellido_paterno']) && isset($row['apellido_materno']) && isset($row['nombres'])) {
                $alumno = Alumno::where('paterno', trim($row['apellido_paterno']))
                    ->where('materno', trim($row['apellido_materno']))
                    ->where('nombres', trim($row['nombres']))
                    ->first();
                if ($alumno) {
                    $escuela = Escuela::where('grado', $row['grado_academico_de'])->first();
                    $condicion_alumno = CondicionAlumno::where('alumno_id', $alumno->id)
                        ->where('condicion_id', 2)->first();
                    $codigo_local = Tablas::where('dep_id', 12)->where('abreviatura', $row['codigo_de_local'])->first();
                    // Actualizando la condición de egresado
                    if($condicion_alumno){
                        $condicion_alumno->update([
                            'codigo_local' => (isset($codigo_local) ? $codigo_local->valor : null),
                            'escuela_id' => $escuela['id'],
                            'anio' => $row['ano'],
                            'resolucion' => $row['reso_n']
                        ]);
                    }else{
                        CondicionAlumno::create([
                            'alumno_id' => $alumno->id,
                            'condicion_id' => 2,
                            'codigo_local' => (isset($codigo_local) ? $codigo_local->valor : null),
                            'escuela_id' => $escuela['id'],
                            'anio' => $row['ano'],
                            'resolucion' => $row['reso_n']
                        ]);
                    }

                } else {
                   /* $alumno = Alumno::create([
                        'paterno' => $row['apellido_paterno'],
                        'materno' => $row['apellido_materno'],
                        'nombres' => $row['nombres'],
                    ]);
                    $escuela = Escuela::where('grado', $row['grado_academico_de'])->first();

                    $codigo_local = Tablas::where('dep_id', 12)->where('abreviatura', $row['codigo_de_local'])->first();
                    // Insertando la condición de egresado
                    CondicionAlumno::create([
                        'alumno_id' => $alumno->id,
                        'condicion_id' => 2,
                        'codigo_local' => (isset($codigo_local) ? $codigo_local->valor : null),
                        'escuela_id' => $escuela['id'],
                        'anio' => $row['ano'],
                        'resolucion' => $row['reso_n']
                    ]);*/
                }
            }
        }
    }

    // this function returns all validation errors after import:
    public function getErrors()
    {
        return $this->errors;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
