<?php

namespace App\Exports;

use App\AlumnoEncuesta;
use App\AlumnoEncuestaDetalle;
use App\EncuestaPregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AlumnoEncuestaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle, WithMapping
{
    private $encuesta;
    private $request;
    private $head_size;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $this->encuesta = AlumnoEncuesta::join('alumno', 'alumno_encuesta.alumno_id', 'alumno.id')
            ->select('alumno_encuesta.id', 'alumno.codigo', DB::raw("CONCAT(IFNULL(alumno.paterno,''),' ',IFNULL(alumno.materno,''),' ', alumno.nombres) as apellidos_nombres"), 'alumno_encuesta.fecha_llenado')
            ->where('alumno_encuesta.encuesta_id', $this->request->encuesta_id);
        if ($this->request->sexo) {
            $this->encuesta = $this->encuesta->where('alumno.sexo', $this->request->sexo);
        }
        return $this->encuesta->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Respuestas';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $head = [
            'CODIGO',
            'APELLIDOS Y NOMBRES',
            'FECHA LLENADO',
        ];

        $preguntas = EncuestaPregunta::join('preguntas', 'encuesta_pregunta.pregunta_id', 'preguntas.id')
            ->where('encuesta_pregunta.encuesta_id', $this->request->encuesta_id)->get();
        foreach ($preguntas as $pregunta) {
            array_push($head, $pregunta->titulo);
        }
        $this->head_size = count($head);
        return $head;
    }

    public function map($encuesta): array
    {
        $body = [
            $encuesta->codigo,
            $encuesta->apellidos_nombres,
            $encuesta->fecha_llenado,
        ];
        $repuestas = AlumnoEncuestaDetalle::where('alumno_encuesta_detalle.alumno_encuesta_id', $encuesta->id)->get();
        foreach ($repuestas as $repuesta) {
            array_push($body, $repuesta->respuesta);
        }
        return $body;
    }

    public function head_tag()
    {
        $label = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($this->head_size / 26 <= 1) {
            $first_index = round($this->head_size % 26);
            $head = substr($label, $first_index - 1, 1);
        } else {
            $first_index = round($this->head_size / 26);
            $second_index = round($this->head_size % 26);
            $first = substr($label, $first_index - 1, 1);
            $second = substr($label, $second_index - 1, 1);
            $head = $first . $second;
        }
        return $head;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '616161'],
                        ],
                    ],
                    'font' => [
                        'name' => 'Arial',
                        'size' => 12,
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => array('argb' => 'FFBBDEFB'),
                    ]
                ];
                $cellRange = 'A1:' . $this->head_tag() . '1'; // All headers
                $event->getSheet()->getParent()->getDefaultStyle()->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'size' => 10
                    ],
                ]);
                $event->getSheet()->autoSize();
                $event->getSheet()->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }
}
