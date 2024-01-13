<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WebService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WebService>
 */
class WebServiceFactory extends Factory
{
    protected $model = WebService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'todolists',
            'user_id' => User::where('role', 'admin')->first()->id,
            'token' => ['access_token' => 'fake-token'],
        ];
    }
}
