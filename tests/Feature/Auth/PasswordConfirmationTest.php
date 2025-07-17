<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmar_contraseña_pantalla_puede_ser_renderizada(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_la_contraseña_puede_ser_confirmada(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = Volt::test('auth.confirm-password')
            ->set('password', 'password')
            ->call('confirmPassword');

        $response
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_la_contraseña_no_esta_confirmada_con_una_contraseña_no_valida(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = Volt::test('auth.confirm-password')
            ->set('password', 'wrong-password')
            ->call('confirmPassword');

        $response->assertHasErrors(['password']);
    }
}
