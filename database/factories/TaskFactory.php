<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => Task::NOT_STARTED,
            'todo_list_id' => TodoList::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
