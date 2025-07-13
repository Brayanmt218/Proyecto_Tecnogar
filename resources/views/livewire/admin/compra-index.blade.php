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
        <form action="{{ route('admin.compra.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Eleccion del proveedor --}}
                <div data-flux-field>
                    <label for="proveedor" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Proveedor : <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500" name="provider_id" id="provider_id" required>
                       <option selected disabled>Selecciona una opcion</option>
                       @foreach($providers as $provider)
                        <option value="{{$provider->id}}">{{$provider->company_name}}</option>
                       @endforeach
                    </select>
                    @error('provider')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo de la fecha -->
                <div data-flux-field>
                    <label for="date" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Fecha : <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date" name="date"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="fecha" required data-flux-control>
                    @error('date')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Campo del total -->
                <div data-flux-field>
                    <label for="total" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Total <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="total" name="total"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Total" required data-flux-control>
                    @error('total')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo de tipo de comprovante-->
                <div data-flux-field>
                    <label for="voucher_type" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Tipo Comprobante <span class="text-red-500">*</span>
                    </label>
                    <select name="voucher_type" id="voucher_type" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500" required data-flux-control>
                        <option value="factura" {{ old('tipo_comprobante') == 'factura' ? 'selected' : '' }}>Factura</option>
                        <option value="boleta" {{ old('tipo_comprobante') == 'boleta' ? 'selected' : '' }}>Boleta</option>
                    </select>
                    @error('voucher_type')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
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