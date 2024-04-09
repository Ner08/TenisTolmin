<?php

namespace Database\Factories;

use App\Models\LeagueNews;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeagueNews>
 */
class LeagueNewsFactory extends Factory
{
    protected $model = LeagueNews::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'league_id' => \App\Models\League::factory(), // Use league factory to generate league_id
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true), // Generate 3 paragraphs of content
        ];
    }
}
