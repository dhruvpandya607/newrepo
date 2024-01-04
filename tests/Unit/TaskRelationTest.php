<?php

use App\Models\Task;
use App\Models\TodoList;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test('task belongs to todo list', function () {

    $this->withoutExceptionHandling();

    $todolist = TodoList::factory()->create();
    $task = Task::factory()->make();

    $this->assertInstanceOf(TodoList::class, $task->todolist);
});
