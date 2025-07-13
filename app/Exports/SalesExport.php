<?php

namespace App\Exports;

use App\Models\Sale_detail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection ,WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale_detail::with(['product', 'sale.customer'])->get()->map(function ($item) {
            return [
                'venta_id' => $item->sale->id,
                'cliente' => $item->sale->customer->nombres,
                'dni' => $item->sale->customer->numero_documento,
                'comprobante' => $item->sale->tipo_comprobante,
                'fecha' => $item->sale->fecha,
                'subtotal' => $item->sale->subtotal,
                'igv' => $item->sale->igv,
                'total' => $item->sale->total,
                'producto' => $item->product->name,
                'codigo_producto' => $item->product->nro_serie,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'subtotals' => $item->cantidad * $item->precio_unitario,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Venta',
            'Cliente',
            'DNI',
            'Comprobante',
            'Fecha',
            'Subtotal Venta',
            'IGV',
            'Total Venta',
            'Producto',
            'Serie Producto',
            'Cantidad',
            'Precio Unitario',
            'Subtotal detalle',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes
            'A1:J' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ]
        ];
    }
}
