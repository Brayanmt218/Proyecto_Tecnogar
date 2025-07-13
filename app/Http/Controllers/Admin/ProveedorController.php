<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProvidersExport;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('admin.proveedor.index');
    }
    
    public function consultarRuc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|digits:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $ruc = $request->input('ruc');
        $url = "https://api.apis.net.pe/v2/sunat/ruc?numero={$ruc}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APIS_NET_PE_TOKEN'),
                'Accept' => 'application/json',
            ])->withOptions([
                'verify' => false, // Solo para pruebas locales
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Respuesta de la API para RUC', [
                    'ruc' => $ruc,
                    'response' => $data
                ]);

                // Normalizar la respuesta
                $normalizedData = [
                    'ruc' => $data['numeroDocumento'] ?? $ruc,
                    'company_name' => $data['razonSocial'] ?? '',
                    'direction' => $data['direccion'] ?? '',
                    'status' => $data['estado'] ?? '',
                    'condicion' => $data['condicion'] ?? '',
                ];

                return response()->json($normalizedData);
            } else {
                $error = $response->json()['error'] ?? 'Respuesta no válida';
                Log::error('Error en la consulta a la API', [
                    'ruc' => $ruc,
                    'status' => $response->status(),
                    'error' => $error
                ]);
                return response()->json([
                    'error' => 'No se pudo consultar el RUC: ' . $error
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Excepción al consultar la API', [
                'ruc' => $ruc,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al consultar el RUC: ' . $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'direction' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $provider = Provider::create([
                'ruc' => $request->ruc,
                'company_name' => $request->company_name,
                'direction' => $request->direction,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => true // Por defecto activo
            ]);

            return redirect()->route('admin.proveedor.index')
                ->with('success', 'El Proveedor fue registrada correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'direction' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $provider = Provider::findOrFail($id);
            $provider->update([
                'ruc' => $request->ruc,
                'company_name' => $request->company_name,
                'direction' => $request->direction,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.proveedor.index')
                ->with('success', 'El Proveedor fue actualizada correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }
    public function destroy(string $id)
    {
        $provider = Provider::findOrFail($id);
        $provider->update(['status' => false]);

        return redirect()->route('admin.proveedor.index')
            ->with('success', 'El Proveedor fue eliminado correctamente.');
    }
    public function exportPdf()
    {
    $providers = Provider::where('status', true)->get();
    $pdf = Pdf::loadView('Admin.proveedor.pdf', compact('providers'));
    return $pdf->download('Reporte_Proveedores.pdf');
    }
    public function exportExcel()
    {
    return Excel::download(new ProvidersExport, 'Reporte_Proveedores.xlsx');
    }
}
