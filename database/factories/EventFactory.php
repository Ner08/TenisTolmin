<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventFactory extends Factory
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
            'title' => fake()->sentence(2),
            'description' => fake()->text(),
            'fromDate' => $dateFrom,
            'toDate' =>  $dateTo,
            'location' => fake()->streetAddress(),
        ];
    }
}
