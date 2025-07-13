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
                <a href="{{ route('admin.venta_detalle.export-pdf') }}"
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
                                    <a href="{{ route('admin.venta.imprimir_boleta', $sale->id) }}"
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
        const barcodeInput = $('#nro_serie');
        const addProductButton = $('#add-product');
        const productList = $('#product-list');
        const productsContainer = $('#products-container');
        const totalInput = $('#total-input');
        const subtotalDisplay = $('#subtotal');
        const igvDisplay = $('#igv');
        const totalDisplay = $('#total');
        const customerInput = $('#numero_documento');
        const customerIdInput = $('#customer_id');
        const customerList = $('#customer-list');
        const noCustomerRow = $('#no-customer');
        const noProductsRow = $('#no-products');
        const productCount = $('#product-count');
        let products = [];
        let selectedCustomer = null;

        barcodeInput.focus();

        barcodeInput.on('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addProductButton.click();
            }
        });

        $('#consultar-cliente').on('click', function() {
            const numeroDocumento = customerInput.val().trim();
            if (!numeroDocumento.match(/^\d{8}$/)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El número de documento debe tener 8 dígitos.',
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
                return;
            }

            $.ajax({
                url: '{{ route('admin.venta.get-customer') }}',
                method: 'POST',
                data: JSON.stringify({
                    numero_documento: numeroDocumento
                }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.id) {
                        customerIdInput.val(data.id);
                        selectedCustomer = {
                            id: data.id,
                            nombres: data.nombres,
                            apellidos: data.apellidos
                        };
                        updateCustomerList();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Cliente encontrado correctamente.',
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#22c55e',
                            confirmButtonColor: '#3b82f6',
                            customClass: {
                                popup: 'rounded-lg shadow-lg'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error || 'Cliente no encontrado.',
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#ef4444',
                            confirmButtonColor: '#3b82f6',
                            customClass: {
                                popup: 'rounded-lg shadow-lg'
                            }
                        });
                        customerIdInput.val('');
                        selectedCustomer = null;
                        updateCustomerList();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al consultar el cliente: ' + (xhr.responseJSON
                            ?.error || 'No se pudo conectar con el servidor.'),
                        background: '#18181b',
                        color: '#f4f4f5',
                        iconColor: '#ef4444',
                        confirmButtonColor: '#3b82f6',
                        customClass: {
                            popup: 'rounded-lg shadow-lg'
                        }
                    });
                    customerIdInput.val('');
                    selectedCustomer = null;
                    updateCustomerList();
                }
            });
        });

        addProductButton.on('click', function() {
            const barcode = barcodeInput.val().trim();

            if (!barcode) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, ingrese o escanee un Nro de Serie.',
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
                return;
            }

            $.ajax({
                url: '{{ route('admin.venta.get-product') }}',
                method: 'POST',
                data: JSON.stringify({
                    nro_serie: barcode
                }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.product) {
                        const existingProductIndex = products.findIndex(p => p
                            .nro_serie === data.product.nro_serie);
                        if (existingProductIndex !== -1) {
                            products[existingProductIndex].quantity += 1;
                        } else {
                            products.push({
                                nro_serie: data.product.nro_serie,
                                quantity: 1,
                                name: data.product.name,
                                precio_unitario: parseFloat(data.product
                                    .precio_venta),
                                stock: parseInt(data.product.stock)
                            });
                        }
                        updateProductList();
                        barcodeInput.val('');
                        barcodeInput.focus();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error || 'Producto no encontrado.',
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#ef4444',
                            confirmButtonColor: '#3b82f6',
                            customClass: {
                                popup: 'rounded-lg shadow-lg'
                            }
                        });
                        barcodeInput.val('');
                        barcodeInput.focus();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al buscar el producto: ' + (xhr.responseJSON
                            ?.error || 'No se pudo conectar con el servidor.'),
                        background: '#18181b',
                        color: '#f4f4f5',
                        iconColor: '#ef4444',
                        confirmButtonColor: '#3b82f6',
                        customClass: {
                            popup: 'rounded-lg shadow-lg'
                        }
                    });
                    barcodeInput.val('');
                    barcodeInput.focus();
                }
            });
        });

        function updateCustomerList() {
            customerList.empty();
            if (selectedCustomer) {
                noCustomerRow.hide();
                const row = `
                    <tr class="hover:bg-zinc-700/50 transition-colors">
                        <td class="p-3">${selectedCustomer.id}</td>
                        <td class="p-3">${selectedCustomer.nombres}</td>
                        <td class="p-3">${selectedCustomer.apellidos}</td>
                    </tr>
                `;
                customerList.append(row);
            } else {
                noCustomerRow.show();
            }
        }

        function updateProductList() {
            productList.empty();
            productsContainer.empty();
            let total = 0;

            if (products.length > 0) {
                noProductsRow.hide();
            } else {
                noProductsRow.show();
            }

            products.forEach((product, index) => {
                if (product.quantity > product.stock) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `Stock insuficiente para ${product.name}. Stock disponible: ${product.stock}`,
                        background: '#18181b',
                        color: '#f4f4f5',
                        iconColor: '#ef4444',
                        confirmButtonColor: '#3b82f6',
                        customClass: {
                            popup: 'rounded-lg shadow-lg'
                        }
                    });
                    product.quantity = product.stock;
                }

                const subtotal = product.precio_unitario * product.quantity;
                total += subtotal;
                const row = `
                    <tr class="hover:bg-zinc-700/50 transition-colors">
                        <td class="p-3">${product.name}</td>
                        <td class="p-3">S/ ${product.precio_unitario.toFixed(2)}</td>
                        <td class="p-3">
                            <input type="number" class="quantity-input w-20 px-3 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white text-center"
                                   value="${product.quantity}" min="1" max="${product.stock}"
                                   data-index="${index}" onchange="updateQuantity(${index}, this.value)">
                        </td>
                        <td class="p-3">S/ ${subtotal.toFixed(2)}</td>
                        <td class="p-3 text-right">
                            <button type="button" class="text-red-400 hover:text-red-300 transition-colors p-1 rounded-full hover:bg-red-900/30" onclick="removeProduct(${index})" title="Eliminar producto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                `;
                productList.append(row);

                // Añadir campos ocultos para cada producto
                const productInputs = `
                    <input type="hidden" name="products[${index}][nro_serie]" value="${product.nro_serie}">
                    <input type="hidden" name="products[${index}][quantity]" value="${product.quantity}">
                `;
                productsContainer.append(productInputs);
            });

            const subtotal = total / 1.18;
            const igv = total - subtotal;

            subtotalDisplay.text(`${subtotal.toFixed(2)}`);
            igvDisplay.text(`${igv.toFixed(2)}`);
            totalDisplay.text(`${total.toFixed(2)}`);
            totalInput.val(total.toFixed(2));
            productCount.text(products.length);
        }

        window.updateQuantity = function(index, newQuantity) {
            newQuantity = parseInt(newQuantity);
            if (isNaN(newQuantity) || newQuantity < 1) newQuantity = 1;
            if (newQuantity > products[index].stock) {
                newQuantity = products[index].stock;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Stock insuficiente para ${products[index].name}. Stock disponible: ${products[index].stock}`,
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
            }
            products[index].quantity = newQuantity;
            updateProductList();
        };

        window.removeProduct = function(index) {
            products.splice(index, 1);
            updateProductList();
        };

        $('#sales-form').on('submit', function(e) {
            if (products.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe añadir al menos un producto para registrar la venta.',
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
            } else if (!customerIdInput.val()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe consultar y seleccionar un cliente válido.',
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
            }
        });

        @if (session('print_boleta_id'))
            var saleIdToPrint = {{ session('print_boleta_id') }};
            setTimeout(function() {
                window.open("{{ route('admin.venta.imprimir_boleta', ['sale' => ':saleId']) }}"
                    .replace(':saleId', saleIdToPrint), '_blank');
            }, 500);
        @endif
    });
</script>