<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(300),
            'userId' => $this->faker->numberBetween(1, 2),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
