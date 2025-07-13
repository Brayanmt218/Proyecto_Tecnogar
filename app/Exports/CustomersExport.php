<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection ,WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::query()
            ->select('id', 'tipo_documento', 'numero_documento','nombres','apellidos')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tipo_documento' => $item->tipo_documento,
                    'numero_documento' => $item->numero_documento,
                    'nombres' => $item->nombres,
                    'apellidos' => $item->apellidos,
                ];
            });
    }
    public function headings(): array
    {
        return [
            '#',
            'Tipo Documento',
            'Numero Documento',
            'Nombres',
            'Apellidos',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes para toda la tabla
            'A1:D' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
            // Ajustar ancho de columnas
            'A' => ['width' => 5],
            'B' => ['width' => 20],
            'C' => ['width' => 40],
            'D' => ['width' => 10]
        ];
    }
}
