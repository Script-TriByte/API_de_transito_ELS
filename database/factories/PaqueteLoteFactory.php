<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaqueteLoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idPaquete' => $this->faker->unique()->numberBetween(1, 15),
            'idLote' => $this->faker->unique()->numberBetween(1, 15),
        ];
    }
}
