<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'category_id'  => Category::factory(),
            'condition_id' => Condition::factory(),
            'name'         => $this->faker->word(),
            'brand'        => $this->faker->company(),
            'description'  => $this->faker->sentence(),
            'price'        => $this->faker->numberBetween(100, 10000),
            'is_sold'      => false,
        ];
    }
}