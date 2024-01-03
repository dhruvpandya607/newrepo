<?php


test('fetch all tasks', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $this->createTask();
    $this->withoutExceptionHandling();

    $response = $this->getJson(route('tasks.index', $todolist->id))->json();

    $this->assertEquals(1, count($response));
});


test('store a task with validation', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $task = $this->createTask(['user_id' => auth()->id()]);
    $this->withoutExceptionHandling();

    $storeTask = ['title' => $task->title, 'user_id' => auth()->id()];

    $this->postJson(route('tasks.store', $todolist->id), $storeTask)->json('data');

    $this->assertDatabaseHas('tasks', ['title' => $task->title]);
});


test('update a task with validation', function () {

    $this->authUser();
    $task = $this->createTask();
    $this->withoutExceptionHandling();

    $this->patchJson(route('tasks.update', $task->id), ['title' => 'updated task'])->json('data');

    $this->assertDatabaseHas('tasks', ['title' => 'updated task']);
});


test('delete a task', function () {

    $this->authUser();
    $task = $this->createTask();
    $this->withoutExceptionHandling();

    $this->deleteJson(route('tasks.destroy', $task->id));

    $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
});
