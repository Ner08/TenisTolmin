<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\League>
 */
class LeagueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateFrom = fake()->dateTimeBetween('-1 year');
        $dateTo = fake()->dateTimeBetween($dateFrom,'+2 day');
        return [
            'name' => fake()->sentence(2),
            'description' => fake()->text(),
            'short_description' => fake()->sentence(8),
            'start_date' => $dateFrom,
            'end_date' =>  $dateTo,
        ];
    }
}
