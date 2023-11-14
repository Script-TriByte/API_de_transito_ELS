<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Paquete;
use App\Models\PaqueteLote;

class PaqueteLoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $idPaquetes = Usuario::pluck('idPaquete')->toArray();

        $idPaqueteRestantes = collect($idPaquetes)->filter(function ($idPaquete) {
            return !PaqueteLote::where('idPaquete', $idPaquete)->exists();
        })->toArray();

        $idAAsignar = $idPaqueteRestantes[array_rand($idPaqueteRestantes)];

        return [
            'idPaquete' => $idAAsignar,
            'idLote' => $this->faker->numberBetween(1, 15),
        ];
    }
}
