<?php

namespace Database\Factories;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
