<?php


test('fetching all todo lists', function () {

    $this->authUser();
    $this->createTodolist(['name' => 'first todo list', 'user_id' => auth()->id()]);
    $this->withoutExceptionHandling();

    $response = $this->getJson(route('todo-lists.index'))->json('data');

    $this->assertEquals(1, count($response));
});


test('store a todo list with validation', function () {

    $this->authUser();
    $todolist = $this->createTodolist(['user_id' => auth()->id()]);
    $this->withoutExceptionHandling();

    $storeTodolistData = ['name' => $todolist->name, 'user_id' => $todolist->user_id];

    $this->postJson(route('todo-lists.store'), $storeTodolistData)->json('data');

    $this->assertDatabaseHas('todo_lists', ['name' => $todolist->name, 'user_id' => $todolist->user_id]);
});


test('shows a single todo list', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $this->withoutExceptionHandling();

    $this->getJson(route('todo-lists.show', $todolist->id))->json('data');

    $this->assertDatabaseHas('todo_lists', ['name' => $todolist->name]);
});


test('update a todo list with validation', function () {

    $this->authUser();
    $todolist = $this->createTodolist(['name' => 'first todo list', 'user_id' => auth()->id()]);
    $this->withoutExceptionHandling();

    $this->patchJson(route('todo-lists.update', $todolist->id), ['name' => 'my first todo list'])->json('data');

    $this->assertDatabaseHas('todo_lists', ['name' => 'my first todo list']);
});


test('delete a todo list', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $this->withoutExceptionHandling();

    $this->deleteJson(route('todo-lists.destroy', $todolist->id));

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
});
