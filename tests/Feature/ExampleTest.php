<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_devuelve_una_respuesta_exitosa(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
