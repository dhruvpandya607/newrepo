<?php

use App\Models\Task;
use App\Models\User;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;


beforeEach(function () {

    $this->authUser = Sanctum::actingAs(User::factory()->create(), ['*']);
    $this->withoutExceptionHandling();
});


test('fetch all tasks', function () {

    $todolist = TodoList::factory()->create();
    Task::factory()->create();

    $this->getJson("api/todo-lists/tasks/{$todolist->id}")->assertOK();
});


test('store a task with validation', function () {

    $todolist = TodoList::factory()->create();
    Task::factory()->create();

    $storeTask = [
        'title' => 'first task',
        'user_id' => $this->authUser->id,
        'todo_list_id' => $todolist->id,
    ];

    $this->postJson("api/todo-lists/tasks/{$todolist->id}", $storeTask)->json('data');

    $this->assertDatabaseHas('tasks', [
        'title' => 'first task',
        'user_id' => $this->authUser->id,
    ]);
});


test('update a task with validation', function () {

    $task = Task::factory()->create();

    $updateTask = [
        'title' => 'updated task',
        'status' => Task::STARTED,
    ];

    $this->patchJson("api/todo-lists/tasks/{$task->id}", $updateTask)->json('data');

    $this->assertDatabaseHas('tasks', [
        'title' => 'updated task',
        'status' => Task::STARTED
    ]);
});


test('delete a task', function () {

    $task = Task::factory()->create();

    $this->deleteJson("api/todo-lists/tasks/{$task->id}");

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});
