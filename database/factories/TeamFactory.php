<?php

namespace Database\Factories;

use App\Models\Player;
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
        $player1 = Player::create([
            'p_name' => $this->faker->name(),
            'points' => $this->faker->numberBetween(0, 100),
            // Additional fields if needed
        ]);

        $player2 = Player::create([
            'p_name' => $this->faker->name(),
            'points' => $this->faker->numberBetween(0, 100),
            // Additional fields if needed
        ]);

        $score = $this->faker->numberBetween(0, 100);

        return [
            'bracket_id' => $this->faker->numberBetween(1, 9),
            'p1_id' => $player1->id,
            'p1_name' => $player1->p_name,
            'p1_score' => $score,
            'p1_ranking' => $this->faker->numberBetween(1, 29),
            'p2_id' => $player2->id,
            'p2_name' => $player2->p_name,
            'p2_score' => $this->faker->numberBetween(0, 100),
            'p2_ranking' => $this->faker->numberBetween(1, 29),
            'team_score' => $score + $this->faker->numberBetween(-10, 10),
        ];
    }
}
