<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
});

test('user belongs to many todo lists', function () {

    $user = User::factory()->hasTodolists(3)->create();

    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->todolists);
});

test('user belongs to many tasks', function () {

    $user = User::factory()->hasTasks(3)->create();

    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->tasks);
});
