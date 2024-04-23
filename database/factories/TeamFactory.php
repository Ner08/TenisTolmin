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
            'name' => fake()->name,
            'bracket_id' => $this->faker->numberBetween(1, 9),
            'p1_id' => $player1->id,
            'p2_id' => $player2->id,
        ];
    }
}
