<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\TodoList;


test('user has many todo lists', function () {

    $this->withoutExceptionHandling();

    $user = $this->createUser();
    $todolist = $this->createTodolist(['user_id' => $user->id]);

    $this->assertInstanceOf(TodoList::class, $user->todolist->first());
});
