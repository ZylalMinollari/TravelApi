<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'is_public' => fake()->boolean(),
            'name' => fake()->text(20),
            'description' => fake()->text(),
            'number_of_days' => rand(1,10),
        ];
    }
}
