<?php

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
    $this->todolist = TodoList::find(1);
    Sanctum::actingAs($user, ['*']);
});

test('fetching all todo lists', function () {

    $this->getJson('api/todo-lists')->assertOk();
});

test('store a todo list with validation', function () {

    $todolist = TodoList::find(1)->toArray();

    $this->postJson('api/todo-lists', $todolist)->json('data');

    $this->assertDatabaseHas('todo_lists', $todolist);
});

test('shows a single todo list', function () {

    $todolist = TodoList::factory()->create();

    $this->getJson("api/todo-lists/{$todolist->id}")->json('data');

    $this->assertDatabaseHas('todo_lists', $todolist->toArray());
});

test('update a todo list with validation', function () {

    $todolist = TodoList::factory()->create();

    $updatetodolist = ['name' => 'new todolist'];

    $this->putJson("api/todo-lists/{$todolist->id}", $updatetodolist)->json('data');

    $this->assertDatabaseHas('todo_lists', $updatetodolist);
});

test('delete a todo list', function () {

    $todolist = TodoList::factory()->create();

    $this->deleteJson("api/todo-lists/{$todolist->id}");

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
});
