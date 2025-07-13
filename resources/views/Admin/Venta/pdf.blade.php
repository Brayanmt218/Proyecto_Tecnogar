<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Venta</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 15mm 10mm 10mm 10mm;
            color: #333;
            line-height: 1.4;
        }
        .company-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .company-name {
            display: none; /* lo puedes mostrar si deseas */
        }
        .report-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 10px;
        }
        .header-info {
            margin-bottom: 10px;
        }
        .logo {
            width: 100%;
        }
        .logo img {
            width: 100%;
            height: auto;
            display: block;
        }
        h1 {
            color: #1a73e8;
            font-size: 22px;
            margin: 0;
            font-weight: 600;
        }
        .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        .report-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
        }
        table {
            width: 90%; /* antes era 95% */
            font-size: 10px; /* antes era 11px */
            margin: 0 auto 10px auto;
            border-collapse: collapse;
        }

        th {
            padding: 6px; /* antes era 8px */
            font-size: 9px; /* antes era 10px */
            background-color: #163763;
            color: white;
        }
        td {
            padding: 6px; /* antes era 7px */
            font-size: 8px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e8f0fe;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .status-active {
            color: #34a853;
            font-weight: 600;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #777;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .currency {
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <div class="header-info">
            <h1>Reporte de VENTA</h1>
            <div class="subtitle">Reporte actual del sistema</div>
        </div>
        <div class="logo">
            <img src="{{ public_path('img/electrodomestico.jpg') }}" alt="Logo">
        </div>
    </div>

    <div class="report-info">
        <div>
            <strong>Empresa: </strong> Tecnogar S.A.C
        </div>
        <div>
            <strong>Responsable: </strong> Felipe Ayala Quispe
        </div>
        <div>
            <strong>Sucursal: </strong>Urubamba
        </div>
        <div>
            <strong>Fecha generación:</strong> {{ now()->format('d/m/Y H:i') }}
        </div>
        <div>
            <strong>Total productos:</strong> {{ count($sales) }}
        </div>
        
    </div>

    <table>
        <thead>
            <tr>
                <tr>
                    <th width="3%">#</th>
                    <th width="9%">Cliente</th>
                    <th width="8%">DNI</th>
                    <th width="8%">Comp.</th>
                    <th width="10%">Fecha</th>
                    <th width="8%">SubTotal</th>
                    <th width="6%">IGV</th>
                    <th width="8%">Total</th>
                    <th width="12%">Producto</th>
                    <th width="10%">Serie</th>
                    <th width="4%">Cant.</th>
                    <th width="6%">P. U.</th>
                    <th width="6%">SubT.</th>
                </tr>
            </tr>
        </thead>
        <tbody>
        <tbody>
            @foreach ($sales as $index => $sale)
                @foreach ($sale->saleDetails as $detail)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ optional($sale->customer)->nombres }}</td>
                        <td>{{ optional($sale->customer)->numero_documento }}</td>
                        <td>{{ $sale->tipo_comprobante }}</td>
                        <td>{{ $sale->fecha }}</td>
                        <td>{{ number_format($sale->subtotal, 2) }}</td>
                        <td>{{ $sale->igv }}</td>
                        <td>{{ number_format($sale->total, 2) }}</td>
                        
                        <td>{{ optional($detail->product)->name }}</td>
                        <td>{{ optional($detail->product)->nro_serie }}</td>
                        <td>{{ $detail->cantidad }}</td>
                        <td>{{ number_format($detail->precio_unitario, 2) }}</td>
                        <td>{{ number_format($detail->cantidad * $detail->precio_unitario, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>


        </tbody>
    </table>

    <div class="footer">
        Sistema de Gestión Tecnogar | {{ now()->format('d/m/Y H:i') }} | Página 1 de 1
    </div>
</body>
</html>
