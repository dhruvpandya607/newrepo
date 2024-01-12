<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TodoList;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoListFactory extends Factory
{
    protected $model = TodoList::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'user_id' => User::where('role', 'admin')->first()->id,
            'unique_hash' => Str::random(20),
        ];
    }
}
