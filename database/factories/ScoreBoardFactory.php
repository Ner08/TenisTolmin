<?php

namespace Database\Factories;

use App\Models\ScoreBoard;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreBoardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScoreBoard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'player_name' => $this->faker->name,
            'points' => $this->faker->numberBetween(0, 100),
        ];
    }
}
