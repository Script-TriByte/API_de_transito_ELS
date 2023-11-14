<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehiculoLoteDestinoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idLote' =>  $this->faker->unique()->numberBetween(1, 15),
            'fechaEstimada' => $this->faker->date(),
            'horaEstimada' => $this->faker->time(),
            'docDeIdentidad' => $this->faker->unique()->numberBetween(45000000, 45000015),
        ];
    }
}
