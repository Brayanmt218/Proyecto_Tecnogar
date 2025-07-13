<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="productTable()">
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
                customClass: {
                    popup: 'rounded-lg shadow-lg'
                }
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
                customClass: {
                    popup: 'rounded-lg shadow-lg text-left'
                }
            });
        </script>
    @endif

    <!-- Tabla de Productos -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white" data-flux-component="heading">
                Lista de productos
            </h1>
            <div class="space-x-2">
                <a href="{{ route('admin.producto.export-pdf') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Exportar PDF
                </a>
                <a href="{{ route('admin.producto.export-excel') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Exportar Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nombre</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Descripcion</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Categoria id</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Proveedor Id</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nro serie</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">precio_venta</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">precio_compra</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">stock</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">stock_minimo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Estado</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->name }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->description, 50) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->category->name, 20) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->provider->company_name, 20) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->nro_serie }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ number_format($product->precio_venta, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ number_format($product->precio_compra, 2) }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->stock }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->stock_minimo }}</td>
                            <td class="px-4 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $product->status ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $product->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-right">
                                <!-- Botón Editar -->
                                <button
                                    @click="openModal({{ $product->id }}, '{{ addslashes($product->name) }}','{{ addslashes($product->description) }}',{{ addslashes($product->category_id) }},{{ addslashes($product->provider_id) }},'{{ addslashes($product->nro_serie) }}','{{ addslashes($product->precio_venta) }}','{{ addslashes($product->precio_compra) }}','{{ addslashes($product->stock) }}','{{ addslashes($product->stock_minimo) }}')"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Editar
                                </button>

                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete({{ $product->id }})"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Eliminar
                                </button>

                                <!-- Formulario Eliminar (oculto) -->
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('admin.producto.destroy', $product->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <template x-teleport="body">
        <div x-show="isOpen" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-black opacity-75" @click="closeModal"></div>
                </div>

                <!-- Contenido del Modal -->
                <div
                    class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-800">
                    <form :action="'/admin/producto/' + currentId" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-8 py-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Editar Producto</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Categoría ID -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Categoría</label>
                                    <select x-model="currentCategoryId" name="category_id"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="" disabled>Seleccione una categoría</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Proveedor ID -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Proveedor</label>
                                    <select x-model="currentProviderId" name="provider_id"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="" disabled>Seleccione un proveedor</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Nombre -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Nombre</label>
                                    <input type="text" x-model="currentName" name="name"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <!-- Código Barra -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Nro Serie</label>
                                    <input type="text" x-model="currentNroSerie" name="nro_serie"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <!-- Precio Venta -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Precio Venta</label>
                                    <input type="text" x-model="currentPrecioVenta" name="precio_venta"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <!-- Precio Compra -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Precio Compra</label>
                                    <input type="text" x-model="currentPrecioCompra" name="precio_compra"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Stock</label>
                                    <input type="number" x-model="currentStock" name="stock"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required min="0" step="1" oninput="this.value = Math.floor(this.value)">
                                </div>

                                <!-- Stock Mínimo -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Stock Mínimo</label>
                                    <input type="number" x-model="currentStockMinimo" name="stock_minimo"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required min="0" step="1" oninput="this.value = Math.floor(this.value)">
                                </div>
                                <!-- Descripción -->
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Descripción</label>
                                    <input type="text" x-model="currentDescription" name="description"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                                        required>
                                </div>

                            </div>
                        </div>

                        <div class="px-8 py-4 bg-zinc-800 flex justify-end space-x-4">
                            <button type="button" @click="closeModal" class="px-6 py-3 text-zinc-300 hover:text-white">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</template>
</div>

<script>
    // Función para confirmar eliminación
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Componente Alpine.js para la tabla
    function productTable() {
    return {
        isOpen: false,
        currentId: null,
        currentName: '',
        currentDescription: '',
        currentCategoryId: null,
        currentProviderId: null,
        currentNroSerie: '',
        currentPrecioVenta: 0,
        currentPrecioCompra: 0,
        currentStock: 0,
        currentStockMinimo: 0,

        openModal(id, name, description, category_id, provider_id, nro_serie, precio_venta, precio_compra, stock, stock_minimo) {
            this.currentId = id;
            this.currentName = name;
            this.currentDescription = description;
            this.currentCategoryId = category_id;
            this.currentProviderId = provider_id;
            this.currentNroSerie = nro_serie;
            this.currentPrecioVenta = precio_venta;
            this.currentPrecioCompra = precio_compra;
            this.currentStock = stock;
            this.currentStockMinimo = stock_minimo;
            this.isOpen = true;
            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.isOpen = false;
        }
    }
}


</script>

