<?php

namespace App\Exports;

use App\Models\DetailBuy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Detail_buysExport implements FromCollection ,WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DetailBuy::query()
            ->select('id', 'product_id','buy_id','stock','price_unit')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'date' => $item->buy->date,
                    'stock' => $item->stock,
                    'price_unit' => $item->price_unit,
                ];
            });
    }
    public function headings(): array
    {
        return [
            '#',
            'Nombre Producto',
            'Compra Fecha',
            'Cantidad',
            'Precio Unitario',
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
