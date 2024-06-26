<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsComment>
 */
class NewsCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'news_id' => $this->faker->unique()->randomNumber(),
            'user_id' => $this->faker->unique()->randomNumber(),
            'comment_id' => null,
            'content' => fake()->text()
        ];
    }
}
