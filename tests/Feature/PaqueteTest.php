<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Lote;
use App\Models\Articulo;
use App\Models\User;

class PaqueteTest extends TestCase
{
    public function test_ListarTodosSinAutenticacion()
    {
        $response = $this->get('/api/v3/paquetes', [
            "Accept" => "application/json"
        ]);
        $response->assertStatus(401);
    }

    public function test_ListarTodos()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/paquetes');
        $response->assertStatus(200);
    }

    public function test_ObtenerArticuloDePaqueteExistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/articulos/1');
        $response->assertStatus(200);

        $articulo = $response->decodeResponseJson();
        $this->assertEquals(1, $articulo['idArticulo']);
    }

    public function test_ObtenerArticuloDePaqueteInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/articulos/99');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Paquete inexistente."
        ]);
    }

    public function test_ObtenerDestinoAsignadoDePaqueteExistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/destinos/1');
        $response->assertStatus(200);
        $response->assertIsString();
    }

    public function test_ObtenerDestinoAsignadoDePaqueteInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/destinos/99');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Paquete inexistente."
        ]);
    }

    public function test_ObtenerLoteEnElQueEsta()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/lotes/1');
        $response->assertStatus(200);

        $lote = $response->decodeResponseJson();
        $this->assertEquals(1, $lote['idLote']);
    }

    public function test_ObtenerLoteEnElQueEstaUnPaqueteInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/lotes/99');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Paquete inexistente."
        ]);
    }

    public function test_CalcularTiempoDeLlegada()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/tiempo/1');
        $response->assertStatus(200);
    }

    public function test_CalcularTiempoDeLlegadaDeUnPaqueteInexistente()
    {
        $user = User::first();
        $response = $this->actingAs($user, "api")->get('/api/v3/tiempo/99');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "mensaje" => "Paquete en curso inexistente."
        ]);
    }
}
