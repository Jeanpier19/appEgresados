<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ConveniosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle, WithMapping
{
    private $convenios;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->convenios = DB::table('convenios')
            ->join('entidades', 'convenios.entidad_id', 'entidades.id')
            ->join('tipo_convenio', 'convenios.tipo_convenio_id', 'tipo_convenio.id')
            ->select('convenios.*', 'entidades.nombre as entidad', 'tipo_convenio.descripcion as tipo_convenio');

        if (isset($this->request->estado)) {
            if ($this->request->estado === "POR FINALIZAR") {
                $this->convenios = $this->convenios->whereBetween('convenios.dias_restantes', [0, 30]);
            } else {
                $this->convenios = $this->convenios->where('convenios.estado', $this->request->estado);
            }
        }
        if (isset($this->request->vigencia)) {
            $this->convenios = $this->convenios->where('convenios.vigencia', $this->request->vigencia);
        }
        if (isset($this->request->tipo_convenio)) {
            $this->convenios = $this->convenios->where('tipo_convenio.descripcion', $this->request->tipo_convenio);
        }
        return $this->convenios->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Convenios';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'ENTIDAD',
            'TIPO CONVENIO',
            'NOMBRE',
            'RESOLUCIÓN',
            'OBJETIVO',
            'OBLIGACIONES',
            'FECHA DE INICIO',
            'FECHA DE VENCIMIENTO',
            'DIAS RESTANTES',
            'VIGENCIA',
            'ESTADO'
        ];
    }

    /**
     * @return array
     */
    public function map($encuestas): array
    {
        return [
            $encuestas->id,
            $encuestas->entidad,
            $encuestas->tipo_convenio,
            $encuestas->nombre,
            $encuestas->resolucion,
            $encuestas->objetivo,
            $encuestas->obligaciones,
            $encuestas->fecha_inicio,
            $encuestas->fecha_vencimiento,
            $encuestas->dias_restantes,
            $encuestas->vigencia,
            $encuestas->estado,
        ];
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
                $cellRange = 'A1:' . 'L1'; // All headers
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
