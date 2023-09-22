<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\EstadoEntrega;

class LoteTest extends TestCase
{
    public function test_ConfirmarEntregaDeUnLoteExistente()
    {
        $response = $this->put('api/v2/confirmarEntrega/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "mensaje" => "Se ha entregado el lote correctamente."
        ]);

        EstadoEntrega::where('idLote', 1)->delete();
    }

    public function test_ConfirmarEntregaDeUnLoteInexistente()
    {
        $response = $this->put('api/v2/confirmarEntrega/9999');
        $response->assertStatus(404);
    }
}
