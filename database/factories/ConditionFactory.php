<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->randomElement(['良好', '目立った傷なし', 'やや傷あり', '傷あり']),
        ];
    }
}