<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(150),
            'name' => $this->faker->lastName(),
            'cover_path' => 'default.png',
            'price' => $this->faker->numberBetween(1, 15),
            'quantity' => $this->faker->numberBetween(1, 150),
        ];
    }
}
