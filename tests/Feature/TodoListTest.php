<?php

use App\Models\User;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;


beforeEach(function () {

    $this->authUser = User::factory()->create(['role' => 'admin']);
    Sanctum::actingAs($this->authUser);

    $this->todolist = TodoList::factory()->create(['user_id' => $this->authUser->id]);

    $this->withoutExceptionHandling();
});

test('fetching all todo lists', function () {

    $this->getJson("api/todo-lists")->assertOk();
});


test('store a todo list with validation', function () {

    $storeTodolistData = [
        'name' => 'First TodoList',
        'user_id' => $this->authUser->id,
        'role' => 'admin',
    ];

    $this->postJson("api/todo-lists", $storeTodolistData)->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'First TodoList',
        'user_id' => $this->authUser->id
    ]);
});


test('shows a single todo list', function () {

    $this->getJson("api/todo-lists/{$this->todolist->id}")->json('data');

    $this->assertDatabaseHas('todo_lists', ['name' => $this->todolist->name]);
});


test('update a todo list with validation', function () {

    $updateTodoList = [
        'name' => 'my first todo list',
    ];

    $this->patchJson("api/todo-lists/{$this->todolist->id}", $updateTodoList)->json('data');

    $this->assertDatabaseHas('todo_lists', [
        'name' => 'my first todo list',
        'user_id' => $this->authUser->id
    ]);
});


test('delete a todo list', function () {

    $res = $this->deleteJson("api/todo-lists/{$this->todolist->id}");

    $this->assertDatabaseMissing('todo_lists', ['id' => $this->todolist->id]);
    $res->assertJson([
        'success' => true,
    ]);
});
