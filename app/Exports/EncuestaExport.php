<?php

namespace App\Exports;

use App\Encuesta;
use Carbon\Carbon;
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

class EncuestaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle, WithMapping
{
    private $encuestas;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $this->encuestas = DB::table('encuesta');

        $whereDate = [($this->request->desde === null ? Carbon::parse('2021-01-01') : Carbon::parse($this->request->desde)), Carbon::parse($this->request->hasta)->endOfDay()];
        $this->encuestas = $this->encuestas->whereBetween('encuesta.created_at', $whereDate);
        return $this->encuestas->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Encuestas';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'TITULO',
            'DESCRIPCIÓN',
            'FECHA DE APERTURA',
            'FECHA DE CIERRE',
            'FECHA EXTENDIDA',
            'FECHA DE CREACIÓN'
        ];
    }

    public function map($encuestas): array
    {
        return [
            $encuestas->id,
            $encuestas->titulo,
            $encuestas->descripcion,
            $encuestas->fecha_apertura,
            $encuestas->fecha_vence,
            $encuestas->fecha_extension,
            $encuestas->created_at,
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
                $cellRange = 'A1:' . 'G1'; // All headers
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
