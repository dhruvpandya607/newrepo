<?php


test('fetch all tasks', function () {

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);
    $label = $this->createLabel(['user_id' => $user->id]);
    $task = $this->createTask(['title' => 'first task', 'todo_list_id' => $todolist->id, 'label_id' => $label->id]);

    $this->withoutExceptionHandling();

    $response = $this->getJson(route('tasks.index'));

    $this->assertEquals(1, count($response->json()));
    // $this->assertEquals($this->task->title, $response[0]['title']);
});


test('create a task', function () {

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);
    $label = $this->createLabel(['user_id' => $user->id]);
    $task = $this->createTask(['title' => 'first task', 'todo_list_id' => $todolist->id, 'label_id' => $label->id]);

    $this->withoutExceptionHandling();

    $this->getJson(route('tasks.create'))->assertOk();
});


test('store a task', function () {

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);
    $label = $this->createLabel(['user_id' => $user->id]);
    $task = $this->createTask(['title' => 'first task', 'todo_list_id' => $todolist->id, 'label_id' => $label->id]);

    $this->withoutExceptionHandling();

    $this->postJson(route('tasks.store'), [
        'title' => $task->title, 'user_id' => $user->id, 'todo_list_id' => $todolist->id, 'label_id' => $label->id
    ]);

    $this->assertDatabaseHas('tasks', ['title' => $task->title]);
});


test('update a task', function () {

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);
    $label = $this->createLabel(['user_id' => $user->id]);
    $task = $this->createTask(['title' => 'first task', 'todo_list_id' => $todolist->id, 'label_id' => $label->id]);

    $this->withoutExceptionHandling();

    $this->patchJson(route('tasks.update', $task->id), [
        'todo_list_id' => $todolist->id, 'label_id' => $label->id,
        'title' => $task->title, 'status' => 'started'
    ]);

    $this->assertDatabaseHas('tasks', ['title' => $task->title]);
});


test('delete a task', function () {

    $this->authUser();
    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);
    $label = $this->createLabel(['user_id' => $user->id]);
    $task = $this->createTask([
        'title' => 'first task', 'user_id' => $user->id, 'todo_list_id' => $todolist->id, 'label_id' => $label->id
    ]);

    $this->withoutExceptionHandling();

    $this->deleteJson(route('tasks.destroy', $task->id));

    $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
});
