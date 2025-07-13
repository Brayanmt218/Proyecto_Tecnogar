<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Boleta #{{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Consolas', 'Courier New', monospace;
            margin: 0;
            padding: 0;
            font-size: 11px;
            color: #000;
            line-height: 1.3;
            width: 120mm;
        }

        .ticket-container {
            width: 100%;
            padding: 10mm;
            box-sizing: border-box;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .header-info h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header-info p {
            margin: 0;
            font-size: 10px;
        }

        .receipt-header {
            margin: 12px 0;
        }

        .receipt-header h3 {
            margin: 0;
            font-size: 14px;
        }

        .receipt-header p {
            margin: 3px 0;
        }

        .customer-info p {
            margin: 3px 0;
            font-size: 11px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }

        .product-table th,
        .product-table td {
            padding: 4px 0;
            text-align: left;
            border-bottom: 1px dotted #888;
        }

        .product-table th {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .product-table td {
            font-size: 11px;
        }

        .product-table .qty,
        .product-table .price,
        .product-table .subtotal {
            text-align: right;
        }

        .product-table .product-name {
            width: 50%;
        }

        .product-table .qty {
            width: 15%;
        }

        .product-table .price {
            width: 17%;
        }

        .product-table .subtotal {
            width: 18%;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .totals-table td {
            padding: 3px 0;
            font-size: 12px;
        }

        .totals-table .label {
            text-align: left;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }

        .totals-table .grand-total {
            font-size: 15px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 6px;
        }

        .footer-text {
            font-size: 10px;
            margin-top: 12px;
        }

        @page {
            margin: 0;
            size: 100mm auto;
        }

        html,
        body {
            width: 100mm;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="ticket-container">
        <div class="header-info center">
            <img src="{{ public_path('img/logos.png') }}" alt="Logo Empresa"
                style="max-width: 90px; margin-bottom: 6px;">
            <h2>TECNOGAR S.A.C.</h2>
            <p>RUC: 20607800001</p>
            <p>Dirección: Av. Comercio 456, Urubamba, Cusco</p>
            <p>Teléfono: (084) 321-456</p>
        </div>

        <div class="divider"></div>

        <div class="receipt-header center">
            <h3>{{ strtoupper($sale->tipo_comprobante) }} ELECTRÓNICA</h3>
            <p class="bold">Nº {{ str_pad($sale->id, 8, '0', STR_PAD_LEFT) }}</p>
            <p>Fecha: {{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') }}
                {{ \Carbon\Carbon::parse($sale->created_at)->format('H:i') }}</p>
            <p>Atendido por: {{ $sale->user->name ?? 'N/A' }}</p>
        </div>

        <div class="divider"></div>

        <div class="customer-info">
            <p><strong>Cliente:</strong>
                {{ ($sale->customer->nombres ?? '') . ' ' . ($sale->customer->apellidos ?? 'N/A') }}</p>
            <p><strong>Doc:</strong> {{ $sale->customer->tipo_documento ?? 'N/A' }}:
                {{ $sale->customer->numero_documento ?? 'N/A' }}</p>
            <p><strong>Dir:</strong> {{ $sale->customer->direccion ?? 'N/A' }}</p>
        </div>

        <div class="divider"></div>

        <table class="product-table">
            <thead>
                <tr>
                    <th class="product-name">Descripción</th>
                    <th class="qty center">Cant.</th>
                    <th class="price right">P.Unit</th>
                    <th class="subtotal right">Importe</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sale->saleDetails as $detail)
                    <tr>
                        <td class="product-name">{{ $detail->product->name ?? 'N/A' }}</td>
                        <td class="qty center">{{ $detail->cantidad }}</td>
                        <td class="price right">S/ {{ number_format($detail->precio_unitario, 2) }}</td>
                        <td class="subtotal right">S/
                            {{ number_format($detail->cantidad * $detail->precio_unitario, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="center">No hay productos en esta venta.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="divider"></div>

        <table class="totals-table">
            <tr>
                <td class="label">SUBTOTAL:</td>
                <td class="value">S/ {{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="label">IGV (18%):</td>
                <td class="value">S/ {{ number_format($sale->igv, 2) }}</td>
            </tr>
            <tr>
                <td class="label grand-total">TOTAL:</td>
                <td class="value grand-total">S/ {{ number_format($sale->total, 2) }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="footer-text center">
            <p>¡Gracias por su compra!</p>
            <p>Tecnogar — Electrodomésticos y Tecnología para el hogar</p>
            <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>
