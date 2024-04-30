<?php

namespace Database\Factories;

use App\Models\CustomMatchUp;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomMatchUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomMatchUp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quickDecider = $this->faker->boolean();
        return [
            'bracket_id' => function () {
                // You can define the logic to get a random bracket ID here
                return \App\Models\Bracket::inRandomOrder()->first()->id;
            },
            'team1_id' => function () {
                // You can define the logic to get a random team ID here
                return \App\Models\Team::inRandomOrder()->first()->id;
            },
            'team2_id' => function () {
                // You can define the logic to get a random team ID here
                return \App\Models\Team::inRandomOrder()->first()->id;
            },
            't1_first_set' => $this->faker->numberBetween(0, 7), // Assuming maximum games in a set is 7
            't2_first_set' => $this->faker->numberBetween(0, 7),
            't1_second_set' => $this->faker->numberBetween(0, 7),
            't2_second_set' => $this->faker->numberBetween(0, 7),
            't1_third_set' => $this->faker->numberBetween(0, 7),
            't2_third_set' => $this->faker->numberBetween(0, $quickDecider ? 7 : 10),
            't1_tag' => strtoupper($this->faker->randomLetter()) . rand(1, 9),
            't2_tag' => strtoupper($this->faker->randomLetter()) . rand(1, 9),
            'round' => $this->faker->numberBetween(1, 5),
        ];
    }
}
