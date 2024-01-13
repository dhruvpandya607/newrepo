<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => Task::NOT_STARTED,
            'todo_list_id' => User::find(1)->todolists()->first()->id,
            'user_id' => User::where('role', 'admin')->first()->id,
        ];
    }
}
