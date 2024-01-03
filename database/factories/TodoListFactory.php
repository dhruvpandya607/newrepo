<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TodoListFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
