<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Detail_buysExport;
use App\Http\Controllers\Controller;
use App\Models\DetailBuy;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class DetalleCompraController extends Controller
{
    public function index()
    {
        return view('admin.detallecompra.index');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buy_id' => 'required|exists:buys,id',
            'product_id' => 'required|exists:products,id',
            'stock' => 'required',
            'price_unit' => 'nullable|numeric',
        ]);

        try {
            $validator->validate();

            $detallecompra = DetailBuy::create([
                'buy_id' => $request->buy_id,
                'product_id' => $request->product_id,
                'stock' => $request->stock,
                'price_unit' => $request->price_unit
            ]);

            return redirect()->route('admin.detallecompra.index')
                ->with('success', 'Detalle compra');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'buy_id' => 'required|exists:buys,id',
            'product_id' => 'required|exists:products,id',
            'stock' => 'required',
            'price_unit' => 'nullable|numeric'
        ]);

        try {
            $validator->validate();

            $detallecompra = DetailBuy::findOrFail($id);
            $detallecompra->update([
                'buy_id' => $request->buy_id,
                'product_id' => $request->product_id,
                'stock' => $request->stock,
                'price_unit' => $request->price_unit
            ]);

            return redirect()->route('admin.detallecompra.index')
                ->with('success', 'Detalle venta fue actualizado correctamente');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }
    public function destroy(string $id)
    {
        DetailBuy::find($id)->delete();
        return redirect()->route('admin.detallecompra.index')
            ->with('success', 'Detalle venta fue eliminado correctamnente.');
    }
    public function exportPdf()
    {
    //$buys = Buy::where('status', true)->get();
    $detail_buys = DetailBuy::all(); // ✅ obtiene todas las compras sin filtrar
    $pdf = Pdf::loadView('Admin.detallecompra.pdf', compact('detail_buys'));
    return $pdf->download('Reporte_detalleCompra.pdf');
    }

    public function exportExcel()
    {
    return Excel::download(new Detail_buysExport, 'reporte_detalleCompras.xlsx');
    }
}
