<?php

use App\Models\Task;
use Illuminate\Support\Facades\Artisan;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
});

test('task belongs to todo list', function () {

    $task = Task::factory()->forTodolists()->create();

    $this->assertTrue($task->todolists()->exists());
});

test('task belongs to many users', function () {

    $task = Task::factory()->hasUsers(3)->create();

    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $task->users);
});
