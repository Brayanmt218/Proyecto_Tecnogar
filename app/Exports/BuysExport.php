<?php

namespace App\Exports;

use App\Models\Buy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BuysExport implements FromCollection ,WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Buy::query()
            ->select('id', 'user_id', 'provider_id','date','total','voucher_type')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->user->name,
                    'company_name' => $item->provider->company_name,
                    'date' => $item->date,
                    'total' => $item->total,
                    'voucher_type' => $item->voucher_type,
                ];
            });
    }
    public function headings(): array
    {
        return [
            '#',
            'Nombre Usuario',
            'Nombre Proveedor',
            'Fecha',
            'Total',
            'Tipo Comprobante',
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
