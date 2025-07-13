<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8 space-y-6">
    {{-- Alerta --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#22c55e',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-lg shadow-lg'
                }
            });
        </script>
    @endif

    @if ($errors->any())
        {{-- Eliminar el ')' extra aquí --}}
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-lg shadow-lg text-left'
                }
            });
        </script>
    @endif

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-800">
        <div class="p-6 border-b border-zinc-800 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white" data-flux-component="heading">
                    Historial de Ventas
                </h1>
                <p class="text-zinc-400 mt-1">Listado completo de transacciones registradas</p>
            </div>

            <div class="space-x-2">
                <a href="{{ route('admin.venta.export-pdf') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Exportar PDF
                </a>
                <a href="{{ route('admin.venta.export-excel') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Exportar Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead class="bg-zinc-800">
                    <tr class="border-b border-zinc-700">
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">ID</th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">Cliente
                        </th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">Comprobante
                        </th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">Fecha</th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">Subtotal
                        </th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">IGV</th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">Total</th>
                        <th class="p-4 text-left text-sm font-medium text-zinc-300 uppercase tracking-wider">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-700">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-zinc-800/50 transition-colors">
                            <td class="p-4 font-medium text-blue-400">#{{ $sale->id }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-zinc-700 flex items-center justify-center">
                                        <i class="fas fa-user text-zinc-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">{{ $sale->customer->nombres }}
                                            {{ $sale->customer->apellidos }}</p>
                                        <p class="text-sm text-zinc-400">{{ $sale->customer->numero_documento }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-sm font-medium
                                    {{ $sale->tipo_comprobante === 'Factura'
                                        ? 'bg-green-900/30 text-green-400'
                                        : ($sale->tipo_comprobante === 'Boleta'
                                            ? 'bg-blue-900/30 text-blue-400'
                                            : 'bg-purple-900/30 text-purple-400') }}">
                                    {{ $sale->tipo_comprobante }}
                                </span>
                            </td>
                            <td class="p-4 text-zinc-300">{{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') }}
                            </td>
                            <td class="p-4 font-medium">S/ {{ number_format($sale->subtotal, 2) }}</td>
                            <td class="p-4 text-zinc-300">S/ {{ number_format($sale->igv, 2) }}</td>
                            <td class="p-4 font-bold text-white">S/ {{ number_format($sale->total, 2) }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="toggle-details text-blue-400 hover:text-blue-300 transition-colors p-2 rounded-full hover:bg-blue-900/30"
                                        data-sale-id="{{ $sale->id }}" title="Ver detalles">
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </button>
                                    <a href="#"
                                        class="text-zinc-400 hover:text-white transition-colors p-2 rounded-full hover:bg-zinc-700/50"
                                        title="Imprimir comprobante">
                                        <i class="fas fa-print text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <tr class="details-row hidden bg-zinc-800/30" id="details-{{ $sale->id }}">
                            <td colspan="8" class="p-0">
                                <div class="px-6 py-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-white">
                                            <i class="fas fa-list-ul mr-2 text-blue-400"></i>
                                            Detalles de la Venta #{{ $sale->id }}
                                        </h3>
                                        <span class="text-sm text-zinc-400">
                                            {{ count($sale->saleDetails) }} producto(s)
                                        </span>
                                    </div>

                                    <div class="overflow-x-auto rounded-lg border border-zinc-700">
                                        <table class="w-full text-white">
                                            <thead class="bg-zinc-700/50">
                                                <tr>
                                                    <th class="p-3 text-left text-sm font-medium text-zinc-300">Producto
                                                    </th>
                                                    <th class="p-3 text-left text-sm font-medium text-zinc-300">Nro Serie
                                                    </th>
                                                    <th class="p-3 text-left text-sm font-medium text-zinc-300">Cantidad
                                                    </th>
                                                    <th class="p-3 text-left text-sm font-medium text-zinc-300">Precio
                                                        Unitario</th>
                                                    <th class="p-3 text-left text-sm font-medium text-zinc-300">Subtotal
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-700">
                                                @foreach ($sale->saleDetails as $detail)
                                                    <tr class="hover:bg-zinc-700/30 transition-colors">
                                                        <td class="p-3">
                                                            <div class="flex items-center gap-3">
                                                                <div
                                                                    class="flex-shrink-0 h-8 w-8 rounded bg-zinc-700 flex items-center justify-center">
                                                                    <i class="fas fa-box text-zinc-400 text-xs"></i>
                                                                </div>
                                                                <div>
                                                                    <p class="font-medium text-white">
                                                                        {{ $detail->product->name }}</p>
                                                                    <p class="text-xs text-zinc-400">
                                                                        {{ $detail->product->marca }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="p-3 text-zinc-400 text-sm">
                                                            {{ $detail->product->nro_serie }}</td>
                                                        <td class="p-3">{{ $detail->cantidad }}</td>
                                                        <td class="p-3">S/
                                                            {{ number_format($detail->precio_unitario, 2) }}</td>
                                                        <td class="p-3 font-medium">S/
                                                            {{ number_format($detail->cantidad * $detail->precio_unitario, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center">
                                <div class="flex flex-col items-center justify-center text-zinc-500">
                                    <i class="fas fa-clipboard-list text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No hay ventas registradas</p>
                                    <p class="text-sm mt-1">Cuando realices una venta, aparecerá en este listado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sales->hasPages())
            <div class="px-6 py-4 border-t border-zinc-800 flex items-center justify-between">
                <div class="text-sm text-zinc-400">
                    Mostrando {{ $sales->firstItem() }} a {{ $sales->lastItem() }} de {{ $sales->total() }}
                    resultados
                </div>
                <div class="flex gap-1">
                    @if ($sales->onFirstPage())
                        <span class="px-3 py-1 rounded bg-zinc-800 text-zinc-600 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $sales->previousPageUrl() }}"
                            class="px-3 py-1 rounded bg-zinc-800 text-white hover:bg-zinc-700 transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach (range(1, $sales->lastPage()) as $i)
                        @if ($i == $sales->currentPage())
                            <span class="px-3 py-1 rounded bg-blue-600 text-white">{{ $i }}</span>
                        @else
                            <a href="{{ $sales->url($i) }}"
                                class="px-3 py-1 rounded bg-zinc-800 text-white hover:bg-zinc-700 transition-colors">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if ($sales->hasMorePages())
                        <a href="{{ $sales->nextPageUrl() }}"
                            class="px-3 py-1 rounded bg-zinc-800 text-white hover:bg-zinc-700 transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-3 py-1 rounded bg-zinc-800 text-zinc-600 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.toggle-details').on('click', function() {
            const saleId = $(this).data('sale-id');
            const detailsRow = $(`#details-${saleId}`);
            const icon = $(this).find('i');

            detailsRow.toggleClass('hidden');
            if (detailsRow.hasClass('hidden')) {
                icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        });
    });
</script>