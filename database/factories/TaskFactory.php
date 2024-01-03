<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'todo_list_id' => TodoList::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
