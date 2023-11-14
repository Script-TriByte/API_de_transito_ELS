<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChoferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'docDeIdentidad' => $this->faker->unique()->numberBetween(45000000, 45000015),
        ];
    }
}
