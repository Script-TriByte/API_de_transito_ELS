<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CamionTest extends TestCase
{
    public function test_IntentarListarSinAutenticacion()
    {
        $response = $this->get('/api/v3/contenidos/45000000', [
            "Accept" => "application/json"
        ]);
        $response->assertStatus(401);
    }

    public function test_VerificarFuncionamientoDelListado()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/contenidos/45000000');
        $response->assertStatus(200);
    }

    public function test_ListarContenidosDeUnCamionSinDatos()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/contenidos/{}');
        $response->assertStatus(400);
    }

    public function test_ListarContenidosDeUnChoferInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/contenidos/99999999');
        $response->assertStatus(200);
        $this->assertEquals([], $response->json());
    }
}
