<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CamionTest extends TestCase
{
    public function test_VerificarFuncionamientoDelListado()
    {
        $response = $this->put('/api/v2/contenidos/77777777');
        $response->assertStatus(200);
    }

    public function test_ListarContenidosDeUnCamionSinDatos()
    {
        $response = $this->put('/api/v2/contenidos/{}');
        $response->assertStatus(401);
    }
}
