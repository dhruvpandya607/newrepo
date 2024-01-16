<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    protected $model = Label::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'color' => fake()->colorName(),
            'todo_list_id' => User::find(1)->todolists()->first()->id,
        ];
    }
}
