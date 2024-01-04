<?php

use App\Models\User;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;


beforeEach(function () {

    $this->authUser = Sanctum::actingAs(User::factory()->create());
    $this->withoutExceptionHandling();
});

test('fetching all todo lists', function () {

    TodoList::factory()->create();

    $this->getJson("api/todo-lists")->assertOk();
});


test('store a todo list with validation', function () {

    $todolist = TodoList::factory()->create();

    $storeTodolistData = [
        'name' => 'First TodoList',
        'user_id' => $this->authUser->id,
    ];

    $this->postJson("api/todo-lists", $storeTodolistData)->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'First TodoList',
        'user_id' => $this->authUser->id
    ]);
});


test('shows a single todo list', function () {

    $todolist = TodoList::factory()->create();

    $this->getJson("api/todo-lists/{$todolist->id}")->json('data');

    $this->assertDatabaseHas('todo_lists', ['name' => $todolist->name]);
});


test('update a todo list with validation', function () {

    $todolist = TodoList::factory()->create();

    $updateTodoList = [
        'name' => 'my first todo list',
        'user_id' => $this->authUser->id
    ];

    $this->patchJson("api/todo-lists/{$todolist->id}", $updateTodoList)->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'my first todo list',
        'user_id' => $this->authUser->id
    ]);
});


test('delete a todo list', function () {

    $todolist = TodoList::factory()->create();

    $this->deleteJson("api/todo-lists/{$todolist->id}");

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
});
