<?php

namespace App\Imports;

use App\Egresados;
use App\Models\Alumno;
use App\Models\Facultad;
use App\Models\Escuela;
use App\Condicion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EgresadosNImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    private $facultad;
    private $escuela;
    private $condicion;

    public function __construct()
    {
        $this->facultad = Facultad::pluck('id', 'nombre');
        $this->escuela = Escuela::pluck('id', 'nombre');
        $this->condicion = Condicion::pluck('id', 'descripcion');
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Buscar al alumno por el código de estudiante
        $alumno = Alumno::where('codigo', $row['codigo_estudiante'])->first();

        // Si el alumno no existe, crearlo
        if (!$alumno) {
            $alumno = Alumno::create([
                'codigo' => $row['codigo_estudiante'],
                'num_documento' => $row['dni'],
                'paterno' => $row['apellido_paterno'],
                'materno' => $row['apellido_materno'],
                'nombres' => $row['nombres'],
                'sexo' => $row['genero'],
            ]);
        }

        // Verifica si ya existe un egresado con el mismo código de estudiante
        $egresadoExistente = Egresados::where('alumnos_id', $alumno->id)->first();

        // Si ya existe un egresado para este alumno, actualiza sus datos
        if ($egresadoExistente) {
            $egresadoExistente->update([
                'anio' => $row['anio'],
                'ciclo' => $row['ciclo'],
                'codigo_local' => $row['codigo_de_local'],
                'facultad_id' => $this->facultad[$row['facultad']],
                'escuela_id' => $this->escuela[$row['escuela']],
                'codigo' => $row['codigo_estudiante'],
                'num_documento' => $row['dni'],
                'paterno' => $row['apellido_paterno'],
                'materno' => $row['apellido_materno'],
                'nombres' => $row['nombres'],
                'f_ingreso' => $row['ingreso'],
                'f_egreso' => $row['egreso'],
                'grado_academico' => $this->condicion[$row['grado_academico']],
                'sexo' => $row['genero'],
            ]);
            return $egresadoExistente;
        }

        // Crear un nuevo registro de egresado
        return new Egresados([
            'anio' => $row['anio'],
            'ciclo' => $row['ciclo'],
            'codigo_local' => $row['codigo_de_local'],
            'facultad_id' => $this->facultad[$row['facultad']],
            'escuela_id' => $this->escuela[$row['escuela']],
            'alumnos_id' => $alumno->id,
            'codigo' => $row['codigo_estudiante'],
            'num_documento' => $row['dni'],
            'paterno' => $row['apellido_paterno'],
            'materno' => $row['apellido_materno'],
            'nombres' => $row['nombres'],
            'f_ingreso' => $row['ingreso'],
            'f_egreso' => $row['egreso'],
            'grado_academico' => $this->condicion[$row['grado_academico']],
            'sexo' => $row['genero'],
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8', // Codificación de caracteres de entrada del archivo Excel
            'delimiter' => ',', // Delimitador de columnas en el archivo CSV
            'enclosure' => '"', // Caracter de comillas para encerrar valores de campo
            'escape_character' => '\\', // Carácter de escape para valores especiales
        ];
    }
}
