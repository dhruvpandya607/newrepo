<?php

use App\Models\TodoList;
use App\Models\User;


test('fetching all todolists', function () {

    $user = User::factory()->create();
    TodoList::factory()->create(['user_id' => $user->id]);

    $this->getJson('api/todo-lists')->assertOk();
});


test('shows a single todolist', function () {
    
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $todolist = TodoList::factory()->create(['user_id' => $user->id]);

    $this->getJson("api/todo-lists/{$todolist->id}")->assertOk();
});
