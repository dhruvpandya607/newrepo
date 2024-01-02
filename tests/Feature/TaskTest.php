<?php


test('fetch all tasks', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $label = $this->createLabel(['user_id' => auth()->id()]);
    $task = $this->createTask(['todo_list_id' => $todolist->id, 'label_id' => $label->id]);
    $this->withoutExceptionHandling();

    $response = $this->getJson(route('tasks.index', $todolist->id))->json('data');

    $this->assertEquals(1, count($response));
});


test('store a task without label', function () {

    $this->authUser();
    $todolist = $this->createTodolist(['user_id' => auth()->id()]);
    $task = $this->createTask();
    $this->withoutExceptionHandling();

    $this->postJson(route('tasks.store', $todolist->id), ['title' => $task->title])
        ->json('data');

    $this->assertDatabaseHas('tasks', ['title' => $task->title]);
});


test('store a task with label with validation', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $label = $this->createLabel();
    $task = $this->createTask(['todo_list_id' => $todolist->id, 'label_id' => $label->id]);
    $this->withoutExceptionHandling();

    $this->postJson(route('tasks.store', $todolist->id), ['title' => $task->title, 'label_id' => $label->id])
        ->json('data');

    $this->assertDatabaseHas('tasks', ['title' => $task->title, 'label_id' => $label->id]);
});


test('update a task with validation', function () {

    $this->authUser();
    $todolist = $this->createTodolist();
    $task = $this->createTask(['todo_list_id' => $todolist->id]);
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
