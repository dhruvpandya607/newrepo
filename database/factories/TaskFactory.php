<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'user_id' => User::factory()->create()->id,
            'todo_list_id' => TodoList::factory()->create()->id,
            'label_id' => Label::factory()->create()->id,
        ];
    }
}
