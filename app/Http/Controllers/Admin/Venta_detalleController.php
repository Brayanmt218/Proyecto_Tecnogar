<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Venta_detalleController extends Controller
{
    public function index()
    {
        return view('admin.venta_detalle.index');
    }
    
    public function exportPdf()
    {
        $sales = Sale::orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('admin.venta_detalle.pdf', compact('sales'));
        return $pdf->download('reporte_venta_detalle.pdf');
    }

    public function generateBoletaPrint(Sale $sale)
    {
        $sale->load(['user', 'customer', 'saleDetails.product']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.venta_detalle.boleta_pdf', compact('sale'));
        $pdf->setPaper([0, 0, 340.36, $pdf->getDomPDF()->getCanvas()->get_height()], 'portrait');

        return $pdf->stream('boleta-' . $sale->id . '.pdf');
    }
}

