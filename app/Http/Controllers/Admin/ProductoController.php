<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function index()
    {
        return view('admin.producto.index');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'=>'required|exists:categories,id',
            'provider_id'=>'required|exists:providers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nro_serie' => 'required|string|unique:products,nro_serie',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        try {
            $validator->validate();

            $product = Product::create([
                'category_id'=>$request->category_id,
                'provider_id'=>$request->provider_id,
                'name' => $request->name,
                'description' => $request->description,
                'nro_serie' => $request->nro_serie,
                'precio_venta' => $request->precio_venta,
                'precio_compra' => $request->precio_compra,
                'stock' => $request->stock,
                'stock_minimo' => $request->stock_minimo,
                'status' => true // Por defecto activo
            ]);

            return redirect()->route('admin.producto.index')
                ->with('success', 'El Producto fue registrada correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }
    public function update(Request $request, string $id)
        {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'provider_id' => 'required|exists:providers,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'nro_serie' => 'required|string',
                'precio_venta' => 'required|numeric|min:0',
                'precio_compra' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'stock_minimo' => 'required|integer|min:0',
            ]);

            try {
                $validator->validate();

                $product = Product::findOrFail($id); // ✅ Buscar por ID

                $product->update([ // ✅ Actualizar los campos
                    'category_id' => $request->category_id,
                    'provider_id' => $request->provider_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'nro_serie' => $request->nro_serie,
                    'precio_venta' => $request->precio_venta,
                    'precio_compra' => $request->precio_compra,
                    'stock' => $request->stock,
                    'stock_minimo' => $request->stock_minimo,
                ]);

                return redirect()->route('admin.producto.index')
                    ->with('success', 'El Producto fue actualizado correctamente.');

            } catch (ValidationException $e) {
                return back()->withErrors($e->validator->errors())->withInput();
            }
        }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => false]);

        return redirect()->route('admin.producto.index')
            ->with('success', 'El Producto fue eliminado correctamente.');
    }
    public function exportPdf()
    {
    $products = Product::where('status', true)->get();
    $pdf = Pdf::loadView('Admin.producto.pdf', compact('products'));
    return $pdf->download('Reporte_Productos.pdf');
    }
    public function exportExcel()
    {
    return Excel::download(new ProductsExport, 'Reporte_Productos.xlsx');
    }
}
