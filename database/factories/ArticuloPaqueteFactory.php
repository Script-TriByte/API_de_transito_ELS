<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Paquete;

class ArticuloPaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $paquete = Paquete::findOrFail(1);

        return [
            'idArticulo' => '1',
            'idPaquete' => $paquete->idPaquete,
        ];
    }
}
