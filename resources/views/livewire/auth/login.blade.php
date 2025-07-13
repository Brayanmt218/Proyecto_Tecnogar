<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-blue-50 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white shadow-2xl rounded-3xl p-8 md:p-10">

        <!-- LOGO -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/logos.png') }}" alt="Logo Tecnogar" class="h-20 w-20 object-contain">
        </div>

        <!-- ENCABEZADO -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-zinc-800">Bienvenido a Tecnogar</h2>
            <p class="text-sm text-zinc-500 mt-1">Tu tienda de confianza en electrodomésticos</p>
        </div>

        <!-- ESTADO DE SESIÓN -->
        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <!-- FORMULARIO -->
        <form wire:submit="login" class="space-y-6">
            <!-- EMAIL -->
            <flux:input
                wire:model="email"
                label="Correo electrónico"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="Administrador@tecnogar.com"
            />

            <!-- CONTRASEÑA -->
            <div class="relative">
                <flux:input
                    wire:model="password"
                    label="Contraseña"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="•••••••••••"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link
                        class="absolute top-0 right-0 text-xs text-blue-600 hover:underline"
                        :href="route('password.request')"
                        wire:navigate
                    >
                        ¿Olvidaste tu contraseña?
                    </flux:link>
                @endif
            </div>

            <!-- RECORDARME -->
            <flux:checkbox wire:model="remember" label="Mantener sesión activa" />

            <!-- BOTÓN INGRESAR -->
            <div>
                <flux:button type="submit" variant="primary" class="w-full">
                    Ingresar
                </flux:button>
            </div>
        </form>

        <!-- REGISTRO -->
        @if (Route::has('register'))
            <div class="mt-6 text-center text-sm text-zinc-600">
                ¿No tienes cuenta?
                <flux:link :href="route('register')" wire:navigate class="text-blue-600 hover:underline">
                    Crea una aquí
                </flux:link>
            </div>
        @endif
    </div>
</div>

