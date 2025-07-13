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
        <h1 class="text-2xl font-bold text-white mb-6" data-flux-component="heading">
            Realizar la compra
        </h1>
        <form action="{{ route('admin.detallecompra.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Producto  el nombre del producto--}}
                <div data-flux-field>
                    <label for="producto" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Producto : <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500" name="product_id" id="product_id" required>
                       <option selected disabled>Selecciona una opción</option>
                       @foreach($products as $product)
                           <option value="{{$product->id}}">{{$product->name}}</option>
                       @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Seleccionmaos la fecha de la compra --}}
                <div data-flux-field>
                    <label for="compra" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Compra : <span class="text-red-500">*</span>
                    </label>
                    <select id="buy_id" name="buy_id"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white"
                        required data-flux-control>
                        <option value="" disabled selected>Seleccione una compra</option>
                        @foreach ($buys as $buy)
                            <option value="{{ $buy->id }}">{{ $buy->date }} - {{ $buy->total }} - ({{ $buy->voucher_type }})</option>
                        @endforeach
                    </select>
                    @error('buy_id')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div data-flux-field>
                    <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Cantidad" required>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio unitario --}}
                <div data-flux-field>
                    <label for="price_unit" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Precio unitario <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="price_unit" name="price_unit"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Monto" required>
                    @error('price_unit')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Separador -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
            </div>

            <!-- Nota de campos obligatorios -->
            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>

            <!-- Botón de acción principal -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl"
                    data-flux-component="button">
                    Registrar compra
                </button>
            </div>
        </form>
    </div>
</div>
