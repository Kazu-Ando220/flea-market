<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'  => User::factory(),
            'avatar'   => null,
            'post_code' => '123-4567',
            'address'  => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
        ];
    }
}