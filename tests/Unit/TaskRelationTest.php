<?php

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Support\Facades\Artisan;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test('task belongs to todo list', function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->withoutExceptionHandling();

    $task = Task::factory()->forTodolists()->create();

    $this->assertTrue($task->todolists()->exists());
});
