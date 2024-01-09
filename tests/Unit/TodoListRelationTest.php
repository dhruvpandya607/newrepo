<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\Task;
use App\Models\TodoList;

test('todo lists has many tasks', function () {

    $this->withoutExceptionHandling();

    $todolist = TodoList::factory()->create();
    $task = Task::factory()->create(['todo_list_id' => $todolist->id]);

    $this->assertInstanceOf(Task::class, $todolist->task->first());
});

test('deleting todo list also deletes its tasks', function () {

    $this->withoutExceptionHandling();

    $todolist = TodoList::factory()->create();
    $todolist2 = TodoList::factory()->create();
    $task = $this->createTask(['todo_list_id' => $todolist->id]);
    $task2 = $this->createTask(['todo_list_id' => $todolist2->id]);

    $todolist->delete();

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
});
