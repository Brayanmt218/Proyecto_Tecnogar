<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            Registrar Nueva Empresa
        </h1>
        <form action="{{ route('admin.proveedor.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campo RUC -->
                <div data-flux-field>
                    <label for="ruc" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        RUC <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="ruc" name="ruc"
                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                            placeholder="Ej: 12345678901" required pattern="\d{11}" maxlength="11"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-flux-control>
                        <button type="button" id="consultar-ruc"
                            class="px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </button>
                    </div>
                    @error('ruc')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Razón Social -->
                <div data-flux-field>
                    <label for="company_name" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Razón Social <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="company_name" name="company_name"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: Empresa S.A." required maxlength="255" data-flux-control>
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Dirección -->
                <div data-flux-field>
                    <label for="direction" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Dirección <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="direction" name="direction"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: Av. Principal 123" required maxlength="255" data-flux-control>
                    @error('direction')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Teléfono -->
                <div data-flux-field>
                    <label for="phone" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Teléfono <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="phone" name="phone"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 987654321" required pattern="\d{9}" maxlength="9"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-flux-control>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Email -->
                <div data-flux-field>
                    <label for="email" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: contacto@empresa.com" required maxlength="255" data-flux-control>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
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
                    Registrar Empresa
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#consultar-ruc').on('click', function () {
            const ruc = $('#ruc').val();
            if (!ruc.match(/^\d{11}$/)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El RUC debe tener 11 dígitos',
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
                url: '{{ route('admin.proveedor.consultar-ruc') }}',
                method: 'GET',
                data: { ruc: ruc },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    console.log('Respuesta del controlador:', data); // Depuración
                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#ef4444',
                            confirmButtonColor: '#3b82f6',
                            customClass: {
                                popup: 'rounded-lg shadow-lg'
                            }
                        });
                    } else {
                        $('#ruc').val(data.ruc || '');
                        $('#company_name').val(data.company_name || '');
                        $('#direction').val(data.direction || '');
                        // Teléfono y email no vienen de la API, se dejan vacíos
                        $('#phone').val('');
                        $('#email').val('');
                        if (!data.company_name || !data.direction) {
                            console.warn('Advertencia: Algunos campos no se recibieron correctamente');
                        }
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Datos del RUC obtenidos correctamente',
                            background: '#18181b',
                            color: '#f4f4f5',
                            iconColor: '#22c55e',
                            confirmButtonColor: '#3b82f6',
                            customClass: {
                                popup: 'rounded-lg shadow-lg'
                            }
                        });
                    }
                },
                error: function (xhr) {
                    console.log('Error en la solicitud AJAX:', xhr.responseJSON); // Depuración
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al consultar el RUC: ' + (xhr.responseJSON?.error || 'No se pudo conectar con la API'),
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
        });
    });
</script>
