<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(15)->create();
        \App\Models\Usuario::factory(15)->create();
        \App\Models\Chofer::factory(15)->create();
        \App\Models\Destino::factory(15)->create();
        \App\Models\Articulo::factory(15)->create();
        \App\Models\ArticuloPaquete::factory(15)->create();
        \App\Models\Paquete::factory(15)->create();
        \App\Models\PaqueteLote::factory(15)->create();
        \App\Models\Lote::factory(15)->create();
        \App\Models\VehiculoLoteDestino::factory(15)->create();
    }
}
