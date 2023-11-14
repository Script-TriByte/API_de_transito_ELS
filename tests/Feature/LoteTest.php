<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoteTest extends TestCase
{
    public function test_ConfirmarEntregaSinAutenticacion()
    {
        $response = $this->post('api/v3/entrega/1/77777777', [
            "Accept" => "application/json"
        ]);
        $response->assertStatus(401);
    }

    public function test_ConfirmarEntregaDeUnLoteExistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('api/v3/entrega/1/77777777');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Se ha entregado el lote correctamente."
        ]);
    }

    public function test_ConfirmarEntregaDeUnLoteInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->post('api/v3/confirmarEntrega/9999/77777777');
        $response->assertStatus(404);
    }
}
