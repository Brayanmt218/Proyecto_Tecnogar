<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ClienteController extends Controller
{
    public function index()
    {
        return view('admin.cliente.index');
    }

    public function create()
    {
        return view('admin.cliente.create');
    }

    public function consultarDni(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required|digits:8',
            'tipo_documento' => 'required|in:DNI,CE',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $dni = $request->input('dni');
        $tipoDocumento = $request->input('tipo_documento');
        $url = "https://api.apis.net.pe/v2/reniec/dni?numero={$dni}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APIS_NET_PE_TOKEN'),
                'Accept' => 'application/json',
            ])->withOptions([
                'verify' => false, // Solo para pruebas locales
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                // Registrar la respuesta completa para depuración
                Log::info('Respuesta de la API para DNI/CE', [
                    'dni' => $dni,
                    'tipo_documento' => $tipoDocumento,
                    'response' => $data
                ]);

                // Normalizar la respuesta
                $normalizedData = [
                    'numero' => $data['numeroDocumento'] ?? $dni,
                    'nombres' => $data['nombres'] ?? '',
                    'apellidos' => $this->normalizeApellidos($data),
                    'tipo_documento_api' => $data['tipoDocumento'] ?? '',
                    'digito_verificador' => $data['digitoVerificador'] ?? '',
                ];

                return response()->json($normalizedData);
            } else {
                $error = $response->json()['error'] ?? 'Respuesta no válida';
                Log::error('Error en la consulta a la API', [
                    'dni' => $dni,
                    'status' => $response->status(),
                    'error' => $error
                ]);
                return response()->json([
                    'error' => 'No se pudo consultar el documento: ' . $error
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Excepción al consultar la API', [
                'dni' => $dni,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al consultar el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    private function normalizeApellidos(array $data): string
    {
        // Manejar diferentes estructuras de la respuesta
        if (isset($data['apellidos']) && !empty($data['apellidos'])) {
            return $data['apellidos'];
        }

        // Ajustar para camelCase como devuelve la API
        $apellidoPaterno = $data['apellidoPaterno'] ?? '';
        $apellidoMaterno = $data['apellidoMaterno'] ?? '';
        $apellidos = trim("{$apellidoPaterno} {$apellidoMaterno}");

        if (empty($apellidos)) {
            // Intentar con otros posibles campos
            $apellidos = $data['nombreCompleto'] ?? $data['apellido'] ?? $data['apellidos_completos'] ?? '';
            // Si nombreCompleto está presente, extraer solo los apellidos (quitar nombres)
            if (!empty($apellidos) && isset($data['nombres'])) {
                $apellidos = str_replace($data['nombres'], '', $apellidos);
                $apellidos = trim($apellidos);
            }
        }

        return $apellidos;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento' => 'required|string|in:DNI,CE|max:20',
            'numero_documento' => 'required|string|digits:8|unique:customers,numero_documento',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
        ]);

        try {
            $validator->validate();

            $customer = Customer::create([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
            ]);

            return redirect()->route('admin.cliente.index')->with('success', 'El cliente fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento' => 'required|string|in:DNI,CE|max:20',
            'numero_documento' => 'required|string|digits:8|unique:customers,numero_documento,' . $id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
        ]);

        try {
            $validator->validate();

            $customer = Customer::findOrFail($id);
            $customer->update([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
            ]);

            return redirect()->route('admin.cliente.index')->with('success', 'El cliente se actualizó correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('admin.cliente.index')->with('success', 'El cliente fue eliminado correctamente.');
    }
    public function exportPdf()
    {
    //$buys = Buy::where('status', true)->get();
    $customers = Customer::all(); // ✅ obtiene todas las compras sin filtrar
    $pdf = Pdf::loadView('Admin.cliente.pdf', compact('customers'));
    return $pdf->download('Reporte_Clientes.pdf');
    }
    public function exportExcel()
    {
    return Excel::download(new CustomersExport, 'Reporte_Clientes.xlsx');
    }
}
