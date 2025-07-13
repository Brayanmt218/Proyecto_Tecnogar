<?php

namespace App\Exports;

use App\Models\Provider;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProvidersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Provider::where('status', true)
            ->select('id', 'ruc', 'company_name','direction','phone','email','status')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ruc' => $item->ruc,
                    'company_name' => $item->company_name,
                    'direction' => $item->direction,
                    'phone' => $item->phone,
                    'email' => $item->email,
                    'status' => $item->status ? 'Activo' : 'Inactivo'
                ];
            });
    }
    public function headings(): array
    {
        return [
            '#',
            'Ruc',
            'Razon_Social',
            'Direccion',
            'Telefono',
            'Correo_Electronico',
            'Estado'
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
