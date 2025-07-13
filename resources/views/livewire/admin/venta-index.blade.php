<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Notificaciones -->
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
                customClass: { popup: 'rounded-lg shadow-lg' }
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6',
                customClass: { popup: 'rounded-lg shadow-lg text-left' }
            });
        </script>
    @endif

    <!-- Formulario de Venta -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white" data-flux-component="heading">
                Registrar Venta
            </h1>
            <div class="text-sm text-zinc-500">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>
        </div>

        <form id="sales-form" action="{{ route('admin.venta.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf

            <!-- Sección de Datos Básicos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campo Número de Documento -->
                <div data-flux-field>
                    <label for="numero_documento" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Número de Documento <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="numero_documento" name="numero_documento"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                            placeholder="Ej: 12345678" required pattern="\d{8}" maxlength="8"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-flux-control>
                        <input type="hidden" id="customer_id" name="customer_id">
                        <button type="button" id="consultar-cliente"
                            class="px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center"
                            title="Consultar cliente">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </button>
                    </div>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Tipo de Comprobante -->
                <div data-flux-field>
                    <label for="tipo_comprobante" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Tipo de Comprobante <span class="text-red-500">*</span>
                    </label>
                    <select id="tipo_comprobante" name="tipo_comprobante"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        required data-flux-control>
                        <option value="" disabled selected>Seleccione un tipo</option>
                        <option value="Boleta">Boleta</option>
                        <option value="Factura">Factura</option>
                        <option value="Nota de Venta">Nota de Venta (Sin efecto tributario)</option>
                    </select>
                    @error('tipo_comprobante')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Código de Barra -->
                <div data-flux-field class="md:col-span-2">
                    <label for="nro_serie" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Nro Serie
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="nro_serie" name="nro_serie"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                            placeholder="Ingrese el numero de serie del producto" data-flux-control>
                        <button type="button" id="add-product"
                            class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Añadir
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sección de Cliente -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-white" data-flux-component="heading">
                        Información del Cliente
                    </h2>
                    <div class="text-sm text-zinc-400">
                        Documento válido requerido
                    </div>
                </div>

                <div class="bg-zinc-800 rounded-lg overflow-hidden border border-zinc-700">
                    <table class="w-full text-white">
                        <thead class="bg-zinc-700/50">
                            <tr>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">ID</th>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">Nombres</th>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">Apellidos</th>
                            </tr>
                        </thead>
                        <tbody id="customer-list" class="divide-y divide-zinc-700">
                            <tr id="no-customer" class="text-center text-zinc-500">
                                <td colspan="3" class="p-4">No se ha seleccionado ningún cliente</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sección de Productos -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-white" data-flux-component="heading">
                        Detalle de Productos
                    </h2>
                    <div class="text-sm text-zinc-400">
                        Total de productos: <span id="product-count">0</span>
                    </div>
                </div>

                <div class="bg-zinc-800 rounded-lg overflow-hidden border border-zinc-700">
                    <table class="w-full text-white">
                        <thead class="bg-zinc-700/50">
                            <tr>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">Producto</th>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">Precio Unitario</th>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">Cantidad</th>
                                <th class="p-3 text-left text-sm font-medium text-zinc-300">Subtotal</th>
                                <th class="p-3 text-right text-sm font-medium text-zinc-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="product-list" class="divide-y divide-zinc-700">
                            <tr id="no-products" class="text-center text-zinc-500">
                                <td colspan="5" class="p-4">No se han añadido productos</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="products-container" style="display: none;"></div>
                <input type="hidden" name="total" id="total-input">
            </div>

            <!-- Resumen de Venta -->
            <div class="mt-8 bg-zinc-800/50 rounded-lg p-6 border border-zinc-700">
                <h3 class="text-lg font-medium text-white mb-4">Resumen de Venta</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-zinc-400">Subtotal:</span>
                        <span class="font-medium">S/ <span id="subtotal">0.00</span></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-400">IGV (18%):</span>
                        <span class="font-medium">S/ <span id="igv">0.00</span></span>
                    </div>
                    <div class="border-t border-zinc-700 my-2"></div>
                    <div class="flex justify-between text-lg">
                        <span class="text-white font-semibold">Total:</span>
                        <span class="text-white font-bold">S/ <span id="total">0.00</span></span>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end gap-4 pt-6">
                <button type="button" onclick="window.location.reload()"
                    class="px-6 py-3 bg-zinc-700 text-white font-medium rounded-lg hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2"
                    data-flux-component="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Registrar Venta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
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

        barcodeInput.on('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addProductButton.click();
            }
        });

        $('#consultar-cliente').on('click', function () {
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
                    customClass: { popup: 'rounded-lg shadow-lg' }
                });
                return;
            }

            $.ajax({
                url: '{{ route('admin.venta.get-customer') }}',
                method: 'POST',
                data: JSON.stringify({ numero_documento: numeroDocumento }),
                contentType: 'application/json',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (data) {
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
                            customClass: { popup: 'rounded-lg shadow-lg' }
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
                            customClass: { popup: 'rounded-lg shadow-lg' }
                        });
                        customerIdInput.val('');
                        selectedCustomer = null;
                        updateCustomerList();
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al consultar el cliente: ' + (xhr.responseJSON?.error || 'No se pudo conectar con el servidor.'),
                        background: '#18181b',
                        color: '#f4f4f5',
                        iconColor: '#ef4444',
                        confirmButtonColor: '#3b82f6',
                        customClass: { popup: 'rounded-lg shadow-lg' }
                    });
                    customerIdInput.val('');
                    selectedCustomer = null;
                    updateCustomerList();
                }
            });
        });

        addProductButton.on('click', function () {
            const barcode = barcodeInput.val().trim();

            if (!barcode) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor,ingrese el numero de serie.',
                    background: '#18181b',
                    color: '#f4f4f5',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#3b82f6',
                    customClass: { popup: 'rounded-lg shadow-lg' }
                });
                return;
            }

            $.ajax({
                url: '{{ route('admin.venta.get-product') }}',
                method: 'POST',
                data: JSON.stringify({ nro_serie: barcode }),
                contentType: 'application/json',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (data) {
                    if (data.product) {
                        const existingProductIndex = products.findIndex(p => p.nro_serie === data.product.nro_serie);
                        if (existingProductIndex !== -1) {
                            products[existingProductIndex].quantity += 1;
                        } else {
                            products.push({
                                nro_serie: data.product.nro_serie,
                                quantity: 1,
                                name: data.product.name,
                                precio_unitario: parseFloat(data.product.precio_venta),
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
                            customClass: { popup: 'rounded-lg shadow-lg' }
                        });
                        barcodeInput.val('');
                        barcodeInput.focus();
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al buscar el producto: ' + (xhr.responseJSON?.error || 'No se pudo conectar con el servidor.'),
                        background: '#18181b',
                        color: '#f4f4f5',
                        iconColor: '#ef4444',
                        confirmButtonColor: '#3b82f6',
                        customClass: { popup: 'rounded-lg shadow-lg' }
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
                        customClass: { popup: 'rounded-lg shadow-lg' }
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4  Registrar Venta
7h16" />
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

        window.updateQuantity = function (index, newQuantity) {
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
                    customClass: { popup: 'rounded-lg shadow-lg' }
                });
            }
            products[index].quantity = newQuantity;
            updateProductList();
        };

        window.removeProduct = function (index) {
            products.splice(index, 1);
            updateProductList();
        };

        $('#sales-form').on('submit', function (e) {
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
                    customClass: { popup: 'rounded-lg shadow-lg' }
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
                    customClass: { popup: 'rounded-lg shadow-lg' }
                });
            }
        });
    });
</script>
