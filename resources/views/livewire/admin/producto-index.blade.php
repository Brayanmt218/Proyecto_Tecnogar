<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
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

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <h1 class="text-2xl font-bold text-white mb-6">
            Registrar nuevo Producto
        </h1>

        <form action="{{ route('admin.producto.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Categoría --}}
                <div>
                    <label for="categoria" class="block text-sm font-medium text-zinc-300 mb-1">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                        <option selected disabled>Selecciona una opción</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Proveedor --}}
                <div>
                    <label for="provider_id" class="block text-sm font-medium text-zinc-300 mb-1">
                        Proveedor <span class="text-red-500">*</span>
                    </label>
                    <select name="provider_id" id="provider_id" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                        <option selected disabled>Selecciona una opción</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->company_name }}</option>
                        @endforeach
                    </select>
                    @error('provider')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nombre del producto --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">
                        Nombre del producto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Nombre del producto">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Código de barra --}}
                <div>
                    <label for="nro_serie" class="block text-sm font-medium text-zinc-300 mb-1">
                        Numero de serie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nro_serie" name="nro_serie" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Numero de serie">
                    @error('nro_serie')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio de venta --}}
                <div>
                    <label for="precio_venta" class="block text-sm font-medium text-zinc-300 mb-1">
                        Precio de venta <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="precio_venta" name="precio_venta" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Precio de venta">
                    @error('precio_venta')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio de compra --}}
                <div>
                    <label for="precio_compra" class="block text-sm font-medium text-zinc-300 mb-1">
                        Precio de compra <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="precio_compra" name="precio_compra" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Precio de compra">
                    @error('precio_compra')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1">
                        Stock del producto <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Stock">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock mínimo --}}
                <div>
                    <label for="stock_minimo" class="block text-sm font-medium text-zinc-300 mb-1">
                        Stock mínimo del producto <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock_minimo" name="stock_minimo" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Stock mínimo">
                    @error('stock_minimo')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-zinc-300 mb-1">
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" cols="10" rows="4"required  class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Descripción del producto"></textarea>
                    {{-- <input type="text" id="description" name="description" required
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg text-white"
                        placeholder="Descripción del producto"> --}}
                    @error('description')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
            </div>

            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition">
                    Registrar Producto
                </button>
            </div>
        </form>
    </div>
</div>
