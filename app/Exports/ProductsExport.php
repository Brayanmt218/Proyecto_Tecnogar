<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection , WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::where('status', true)
            ->select('id','name','description','category_id', 'provider_id','nro_serie','precio_venta','precio_compra','stock','stock_minimo','status')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name_product' => $item->name,
                    'description' => $item->description,
                    'name' => $item->category->name,
                    'company_name' => $item->provider->company_name,
                    'nro_serie' => $item->nro_serie,
                    'precio_venta' => $item->precio_venta,
                    'precio_compra' => $item->precio_compra,
                    'stock' => $item->stock,
                    'stock_minimo' => $item->stock_minimo,
                    'status' => $item->status ? 'Activo' : 'Inactivo'
                ];
            });
    }
    public function headings(): array
    {
        return [
            '#',
            'Nombre Producto',
            'Descripcion',
            'Nombre categoria',
            'Nombre proveedor',
            'Numero Serie',
            'Precio venta',
            'Precio compra',
            'Cantidad',
            'Cantidad minimo',
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
