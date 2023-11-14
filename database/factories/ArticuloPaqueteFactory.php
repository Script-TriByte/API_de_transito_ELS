<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticuloPaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idArticulo' => $this->faker->unique()->numberBetween(1, 15),
            'idPaquete' => $this->faker->unique()->numberBetween(1, 15),
        ];
    }
}
