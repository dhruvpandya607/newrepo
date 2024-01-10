<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\TodoList;
use App\Models\User;

test('user has many todo lists', function () {

    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $todolist = TodoList::factory()->create(['user_id' => $user->id]);

    $this->assertInstanceOf(TodoList::class, $user->todolist->first());
});
