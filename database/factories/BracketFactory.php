<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bracket>
 */
class BracketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'league_id' => fake()->numberBetween(1,3),
            'name' => fake()->sentence(2),
            'description' => fake()->sentence(10),
            'points_description' => fake()->sentence(5),
            'is_group_stage' => fake()->boolean()
        ];
    }
}
