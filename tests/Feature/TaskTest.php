<?php

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    // $user = Sanctum::actingAs(User::factory()->create()->first(), ['*']);
    $user = Sanctum::actingAs(User::find(4), ['*']);

    $this->withHeaders([
        'todolist' => $user->todolists->first()->id,
    ]);

    $this->withoutExceptionHandling();
});

test('fetching all tasks of todolist', function () {

    $todolist = TodoList::factory()->create();

    $this->getJson("api/todo-lists/tasks/{$todolist->id}")->assertOK();
});

test('store a task with validation', function () {

    $todolist = TodoList::factory()->create();
    $storeTask = Task::factory()->raw();

    $this->postJson("api/todo-lists/tasks/{$todolist->id}", $storeTask)->json('data');

    $this->assertDatabaseHas('tasks', $storeTask);
});

test('update a task with validation', function () {

    $task = Task::factory()->create();

    $updateTask = [
        'title' => 'updated task',
        'status' => Task::STARTED,
    ];

    $this->putJson("api/todo-lists/tasks/{$task->id}", $updateTask)->json('data');

    $this->assertDatabaseHas('tasks', $updateTask);
});

test('delete a task', function () {

    $task = Task::factory()->create();

    $this->deleteJson("api/todo-lists/tasks/{$task->id}");

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});
