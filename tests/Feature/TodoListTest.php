<?php

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

test('fetching all todo lists', function () {

    $this->getJson('api/todo-lists')->assertOk();
});

test('store a todo list with validation', function () {

    $storeTodolistData = TodoList::factory()->create()->toArray();

    $this->postJson('api/todo-lists', $storeTodolistData)->json('data');

    $this->assertDatabaseHas('todo_lists', $storeTodolistData);
});

test('shows a single todo list', function () {

    $todolist = TodoList::factory()->make();

    $this->getJson("api/todo-lists/{$todolist->id}")->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => $todolist['name'],
        'user_id' => $todolist['user_id'],
    ]);
});

test('update a todo list with validation', function () {

    $todolist = TodoList::factory()->make();

    $updatetodolist = ['name' => 'new todolist'];
    $this->putJson("api/todo-lists/{$todolist->id}", $updatetodolist)->json('data');

    $this->assertDatabaseHas('todo_lists', $updatetodolist);
});

test('delete a todo list', function () {

    $todolist = TodoList::factory()->create();

    $this->deleteJson("api/todo-lists/{$todolist->id}");

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
});
