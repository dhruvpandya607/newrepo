<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\TodoList;
use Illuminate\Support\Facades\Artisan;


beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->withoutExceptionHandling();
});

test('todo lists has many tasks', function () {

    $todolist = TodoList::factory()->hasTasks()->create();

    $this->assertTrue($todolist->tasks()->exists());
});

test('todo list belongs to many users', function () {

    $todolist = TodoList::factory()->hasUsers(3)->create();

    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $todolist->users);
});
