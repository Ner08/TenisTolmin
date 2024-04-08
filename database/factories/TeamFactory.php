<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $score = $this->faker->numberBetween(0, 100);
        return [
            'bracket_id' => $this->faker->numberBetween(1, 9),
            'p1_name' => $this->faker->name(),
            'p1_score' => $score,
            'p1_ranking' => $this->faker->numberBetween(1, 29),
            'team_score' => $score
        ];
    }
}
