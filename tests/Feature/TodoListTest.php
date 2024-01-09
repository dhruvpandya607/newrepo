<?php

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->authUser = User::factory()->make()->first();
    Sanctum::actingAs($this->authUser);
});

test('fetching all todo lists', function () {

    $this->todolist = TodoList::factory()->create();

    $this->getJson('api/todo-lists')->assertOk();
});

test('store a todo list with validation', function () {

    $this->todolist = TodoList::factory()->create(['user_id' => $this->authUser->id]);

    $storeTodolistData = [
        'name' => 'First TodoList',
    ];

    $this->postJson('api/todo-lists', $storeTodolistData)->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'First TodoList',
    ]);
});

test('shows a single todo list', function () {

    $this->todolist = TodoList::factory()->create(['user_id' => $this->authUser->id]);

    $this->getJson("api/todo-lists/{$this->todolist->id}")->json('data');

    $this->assertDatabaseHas('todo_lists', ['name' => $this->todolist->name]);
});

test('update a todo list with validation', function () {

    $this->todolist = TodoList::factory()->create(['user_id' => $this->authUser->id]);

    $updateTodoList = [
        'name' => 'my first todo list',
    ];
    // dd($this->todolist->id);
    $this->patchJson("api/todo-lists/{$this->todolist->id}", $updateTodoList)->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'my first todo list',
        'user_id' => $this->authUser->id,
    ]);
});

test('delete a todo list', function () {

    $this->todolist = TodoList::factory()->make();

    $res = $this->deleteJson("api/todo-lists/{$this->todolist->id}");

    $this->assertDatabaseMissing('todo_lists', ['id' => $this->todolist->id]);
});
