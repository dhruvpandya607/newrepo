<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'color' => fake()->colorName(),
            'user_id' => User::where('role', 'admin')->first()->id,
            'task_id' => Task::factory()->create()->id,
        ];
    }
}
