<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaqueteTest extends TestCase
{
    public function test_VerificarFuncionamientoDelListado()
    {
        $response = $this->post('/api/v2/listar');
        $response->assertStatus(200);
    }
}
