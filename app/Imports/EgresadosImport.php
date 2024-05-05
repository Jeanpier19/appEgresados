<?php

namespace App\Imports;

use App\CondicionAlumno;
use App\Models\Alumno;
use App\Models\Escuela;
use App\Models\Semestre;
use App\Models\Tablas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EgresadosImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading, WithBatchInserts
{
    use Importable, SkipsFailures;

    private $row_validate;

    private $errors = [];

    public function headingRow(): int
    {
        return 2;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 1;
    }

    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();
        foreach ($rows as $index => $row) {
            if (isset($row['codigo_estudiante'])) {
                $alumno = Alumno::where('codigo', $row['codigo_estudiante'])->first();
                if ($alumno) {
                    $this->row_validate = $alumno;
                    $validator = Validator::make($row, $this->rules_update(), $this->validationMessages());
                    if ($validator->fails()) {
                        foreach ($validator->errors()->messages() as $messages) {
                            foreach ($messages as $error) {
                                $this->errors[] = $error . ' Fila: ' . $row['no'];
                            }
                        }
                    } else {
                        $alumno->update([
                            'paterno' => $row['apellido_paterno'],
                            'materno' => $row['apellido_materno'],
                            'nombres' => $row['nombres'],
                            'tipo_documento' => 'DNI',
                            'num_documento' => ((is_null($row['dni']) || trim($row['dni']) === "") ? null : $row['dni']),
                            'sexo' => ((is_null($row['genero']) || trim($row['genero']) === "") ? null : $row['genero'])
                        ]);

                        $escuela = Escuela::where('nombre', $row['escuela'])->first();

                        if (isset($row['fingreso'])) {
                            $semestre_ingreso = Semestre::where('descripcion', trim($row['fingreso']))->first();
                            $anio_ingreso = Tablas::where('dep_id', 2)
                                ->where('descripcion', substr($row['fingreso'], 0, 4))
                                ->first();
                            if (is_null($semestre_ingreso) && !is_null($anio_ingreso)) {
                                $semestre_ingreso = Semestre::create([
                                    "descripcion" => $row['fingreso'],
                                    "anio" => $anio_ingreso->valor
                                ]);
                            }
                        }
                        $semestre_egreso = Semestre::where('descripcion', trim($row['fegreso']))->first();
                        $anio_egreso = Tablas::where('dep_id', 2)
                            ->where('descripcion', $row['ano'])
                            ->first();
                        if (is_null($semestre_egreso) && !is_null($anio_egreso)) {
                            $semestre_egreso = Semestre::create([
                                "descripcion" => $row['fegreso'],
                                "anio" => $anio_egreso->valor
                            ]);
                        }
                        $condicion_alumno = CondicionAlumno::where('alumno_id', $alumno->id)
                            ->where('condicion_id', 1)->first();
                        $codigo_local = Tablas::where('dep_id', 12)->where('abreviatura', $row['codigo_de_local'])->first();
                        // Insertando la condición de egresado
                        $condicion_alumno->update([
                            'codigo_local' => (isset($codigo_local) ? $codigo_local->valor : null),
                            'escuela_id' => $escuela['id'],
                            'semestre_ingreso' => (isset($row['fingreso']) ? $semestre_ingreso->id : null), 'semestre_egreso' => (is_null($semestre_egreso) ? null : $semestre_egreso->id)
                        ]);
                    }

                } else {
                    $validator = Validator::make($row, $this->rules(), $this->validationMessages());
                    if ($validator->fails()) {
                        foreach ($validator->errors()->messages() as $messages) {
                            foreach ($messages as $error) {
                                $this->errors[] = $error . ' Fila: ' . $row['no'];
                            }
                        }
                    } else {
                        $alumno = Alumno::create([
                            'codigo' => $row['codigo_estudiante'],
                            'paterno' => $row['apellido_paterno'],
                            'materno' => $row['apellido_materno'],
                            'nombres' => $row['nombres'],
                            'tipo_documento' => 'DNI',
                            'num_documento' => ((is_null($row['dni']) || trim($row['dni']) === "") ? null : $row['dni']),
                            'sexo' => ((is_null($row['genero']) || trim($row['genero']) === "") ? null : $row['genero'])
                        ]);
                        $escuela = Escuela::where('nombre', $row['escuela'])->first();

                        if (isset($row['fingreso'])) {
                            $semestre_ingreso = Semestre::where('descripcion', trim($row['fingreso']))->first();
                            $anio_ingreso = Tablas::where('dep_id', 2)
                                ->where('descripcion', substr($row['fingreso'], 0, 4))
                                ->first();
                            if (is_null($semestre_ingreso) && !is_null($anio_ingreso)) {
                                $semestre_ingreso = Semestre::create([
                                    "descripcion" => $row['fingreso'],
                                    "anio" => $anio_ingreso->valor
                                ]);
                            }
                        }
                        $semestre_egreso = Semestre::where('descripcion', trim($row['fegreso']))->first();
                        $anio_egreso = Tablas::where('dep_id', 2)
                            ->where('descripcion', $row['ano'])
                            ->first();
                        if (is_null($semestre_egreso) && !is_null($anio_egreso)) {
                            $semestre_egreso = Semestre::create([
                                "descripcion" => $row['fegreso'],
                                "anio" => $anio_egreso->valor
                            ]);
                        }
                        $codigo_local = Tablas::where('dep_id', 12)->where('abreviatura', $row['codigo_de_local'])->first();
                        // Insertando la condición de egresado
                        CondicionAlumno::create([
                            'alumno_id' => $alumno->id,
                            'condicion_id' => 1,
                            'codigo_local' => (isset($codigo_local) ? $codigo_local->valor : null),
                            'escuela_id' => $escuela['id'],
                            'semestre_ingreso' => (isset($row['fingreso']) ? $semestre_ingreso->id : null),
                            'semestre_egreso' => (is_null($semestre_egreso) ? null : $semestre_egreso->id)
                        ]);
                    }

                }

            }
        }

    }

    public function rules(): array
    {
        return [
            'dni' => 'nullable|unique:alumno,num_documento',
        ];
    }

    public function rules_update(): array
    {
        return [
            'dni' => 'nullable|unique:alumno,num_documento,' . $this->row_validate->id,
        ];
    }

    public function validationMessages()
    {
        return [
            'dni.unique' => 'Dni ya está en uso.',
        ];
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
