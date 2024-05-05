<?php

namespace App\Imports;

use App\Convenio;
use App\Entidad;
use App\TipoConvenio;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class  ConveniosImport implements ToModel, WithHeadingRow
{
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 1;
    }

    /**
     * @param array $row
     *
     * @return void
     */
    public function model(array $row)
    {
        // Buscamos la entidad, si no hay la registramos
        $entidad = Entidad::where('nombre', strtoupper(trim($row['convenios'])))
            ->first();
        if (is_null($entidad)) {
            $entidad = Entidad::create([
                'sector' => strtoupper($row['sector']),
                'tipo' => strtoupper($row['tipo_entidad']),
                'nombre' => strtoupper(trim($row['convenios']))
            ]);
        }
        // Buscamos el tipo convenio, si no hay la registramos
        $tipo_convenio = TipoConvenio::where('descripcion', strtoupper(trim($row['tipo_convenio'])))->first();
        if (is_null($tipo_convenio)) {
            $tipo_convenio = TipoConvenio::create([
                'descripcion' => strtoupper(trim($row['tipo_convenio'])),
            ]);
        }
        if (is_null($row['al'])) {
            $vigencia = "INDEFINIDO";
        } else {
            $vigencia = "DEFINIDO";
        }
        // Registramos el convenio
        Convenio::create([
            'nombre' => trim($row['convenios']),
            'resolucion' => trim(strtoupper($row['resolucion'])),
            'objetivo' => trim($row['objetivo']),
            'obligaciones' => trim($row['obligaciones']),
            'fecha_inicio' => (is_null($row['del']) ? null : Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['del']))),
            'fecha_vencimiento' => (is_null($row['al']) ? null : Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['al']))),
            'vigencia' => $vigencia,
            'estado' => 'VIGENTE',
            'entidad_id' => $entidad->id,
            'tipo_convenio_id' => $tipo_convenio->id
        ]);


    }
}
