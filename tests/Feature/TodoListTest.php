<?php


test('fetching all todo lists', function () {

    $this->withoutExceptionHandling();

    $this->authUser();
    $user = $this->createUser();
    $this->createTodolist(['name' => 'first todo list', 'user_id' => $user->id]);

    $response = $this->getJson(route('todo-lists.index'));

    $this->assertEquals(1, count($response->json()));
});


test('create a todo list', function () {

    $this->authUser();
    $user = $this->createUser();
    $this->createTodolist(['user_id' => $user->id]);

    $this->getJson(route('todo-lists.create'))->assertOk();
});


test('shows a single todo list', function () {

    $this->withoutExceptionHandling();

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);

    $this->getJson(route('todo-lists.show', $todolist->id));

    $this->assertDatabaseHas('todo_lists', ['name' => $todolist->name]);
});


test('store a todo list with validation', function () {

    $this->withoutExceptionHandling();

    $this->authUser();
    $user = $this->createUser();
    $this->createTodolist(['name' => 'first todo list', 'user_id' => $user->id]);

    $this->postJson(route('todo-lists.store'), [
        'name' => 'first todo list', 'user_id' => $user->id,
    ]);

    $this->assertDatabaseHas('todo_lists', ['name' => 'first todo list']);
});


test('update a todo list with validation', function () {

    $this->withoutExceptionHandling();

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);

    $this->patchJson(route('todo-lists.update', $todolist->id), [
        'user_id' => $user->id, 'name' => 'my first todo list',
    ]);

    $this->assertDatabaseHas('todo_lists', ['name' => 'my first todo list']);
});


test('delete a todo list', function () {

    $this->withoutExceptionHandling();

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);

    $this->deleteJson(route('todo-lists.destroy', $todolist->id));

    $this->assertDatabaseMissing('todo_lists', ['name' => $todolist->id]);
});
