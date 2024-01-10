<?php

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->authUser = Sanctum::actingAs(User::factory()->make()->first(), ['*']);

    $this->withoutExceptionHandling();
});

test('fetching all todo lists', function () {

    TodoList::factory()->raw();

    $this->getJson('api/todo-lists')->assertOk();
});

test('store a todo list with validation', function () {

    $storeTodolistData = TodoList::factory()->create([
        'name' => 'First Todolist',
        'user_id' => $this->authUser->id,
    ])->toArray();

    $this->postJson('api/todo-lists', $storeTodolistData)->json('data');

    $this->assertDatabaseHas('todo_lists', $storeTodolistData);
});

test('shows a single todo list', function () {

    $todolist = TodoList::factory()->create([
        'user_id' => $this->authUser->id,
    ]);

    $this->getJson("api/todo-lists/{$todolist->id}")->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => $todolist['name'],
        'user_id' => $todolist['user_id'],
    ]);
});

test('update a todo list with validation', function () {

    $todolist = TodoList::factory()->create([
        'user_id' => $this->authUser->id,
    ]);

    $this->putJson("api/todo-lists/{$todolist->id}", [
        'name' => 'my first todo list',
    ])->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'my first todo list',
    ]);
});

test('delete a todo list', function () {

    $todolist = TodoList::factory()->create(['user_id' => $this->authUser->id]);

    $this->deleteJson("api/todo-lists/{$todolist->id}");

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
});
