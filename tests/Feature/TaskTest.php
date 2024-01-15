<?php

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $user = User::find(1);
    $this->withHeaders([
        'todolist' => $user->todolists()->first()->id,
    ]);
    Sanctum::actingAs($user, ['*']);
});

test('fetching all tasks of todolist', function () {

    $todolist = TodoList::find(1);

    $this->getJson("api/todo-lists/{$todolist->id}/tasks")->assertOK();
});

test('store a task with validation', function () {

    $todolist = TodoList::find(1);
    $storeTask = Task::factory()->raw();

    $this->postJson("api/todo-lists/{$todolist->id}/tasks", $storeTask)->json('data');

    $this->assertDatabaseHas('tasks', $storeTask);
});

test('update a task with validation', function () {

    $task = Task::factory()->create();
    $updateTask = [
        'title' => 'updated task',
        'status' => Task::STARTED,
    ];

    $this->putJson("api/todo-lists/{$task->id}/tasks", $updateTask)->json('data');

    $this->assertDatabaseHas('tasks', $updateTask);
});

test('delete a task', function () {

    $task = Task::factory()->create();

    $this->deleteJson("api/todo-lists/{$task->id}/tasks");

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});
