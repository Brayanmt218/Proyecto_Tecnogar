<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BuysExport;
use App\Http\Controllers\Controller;
use App\Models\Buy;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CompraController extends Controller
{
    public function index()
    {
        return view('admin.compra.index');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_id'=>'required|exists:providers,id',
            'date' => 'required|date',
            'total' => 'nullable|numeric',
            'voucher_type' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $compra = Buy::create([
                //Crea la compra asignando el user_id del usuario autentificado
                'user_id' => auth()->user()->id,
                'provider_id'=>$request->provider_id,
                'date' => $request->date,
                'total' => $request->total,
                'voucher_type' => $request->voucher_type
            ]);

            return redirect()->route('admin.compra.index')
                ->with('success', 'La compra fue registrada exitosamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'provider_id'=>'required|exists:providers,id',
            'date' => 'required|date',
            'total' => 'nullable|numeric',
            'voucher_type' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $compra = Buy::findOrFail($id);
            $compra->update([
                'user_id' => auth()->id(), // ✅ Corregido aquí
                'provider_id' => $request->provider_id,
                'date' => $request->date,
                'total' => $request->total,
                'voucher_type' => $request->voucher_type
            ]);

            return redirect()->route('admin.compra.index')
                ->with('success', 'La compra fue Actualizada exitosamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        Buy::find($id)->delete();
        return redirect()->route('admin.compra.index')
        ->with('success', 'La compra fue eliminada exitosamente.');
    }
    public function exportPdf()
    {
    //$buys = Buy::where('status', true)->get();
    $buys = Buy::all(); // ✅ obtiene todas las compras sin filtrar
    $pdf = Pdf::loadView('Admin.compra.pdf', compact('buys'));
    return $pdf->download('Reporte_Compras.pdf');
    }
    public function exportExcel()
    {
    return Excel::download(new BuysExport, 'Reporte_Compras.xlsx');
    }
}
