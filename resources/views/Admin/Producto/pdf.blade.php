<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos Activos</title>
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
            width: 95%;
            border-collapse: collapse;
            font-size: 11px;
            margin: 0 auto 15px auto;
        }
        th {
            background-color: #1a73e8;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
        }
        td {
            border: 1px solid #e0e0e0;
            padding: 7px;
            vertical-align: top;
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
            <h1>Reporte de Productos Activos</h1>
            <div class="subtitle">Inventario actual del sistema</div>
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
            <strong>Total productos:</strong> {{ count($products) }}
        </div>
        
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="15%">Nombre</th>
                <th width="12%">Categoría</th>
                <th width="12%">Proveedor</th>
                <th width="15%">Descripción</th>
                <th width="10%">Numero Serie</th>
                <th width="8%" class="text-right">P. Venta</th>
                <th width="8%" class="text-right">P. Compra</th>
                <th width="5%" class="text-center">Stock</th>
                <th width="5%" class="text-center">Mínimo</th>
                <th width="7%" class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->provider->company_name }}</td>
                    <td>{{ Str::limit($product->description, 50) }}</td>
                    <td>{{ $product->nro_serie }}</td>
                    <td class="text-right currency">{{ number_format($product->precio_venta, 2) }}</td>
                    <td class="text-right currency">{{ number_format($product->precio_compra, 2) }}</td>
                    <td class="text-center {{ $product->stock < $product->stock_minimo ? 'text-danger' : '' }}">
                        {{ $product->stock }}
                    </td>
                    <td class="text-center">{{ $product->stock_minimo }}</td>
                    <td class="text-center status-active">Activo</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistema de Gestión Tecnogar | {{ now()->format('d/m/Y H:i') }} | Página 1 de 1
    </div>
</body>
</html>
