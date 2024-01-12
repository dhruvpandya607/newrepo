<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Support\Facades\Artisan;


// beforeEach(function () {

//     Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

//     $this->withoutExceptionHandling();
// });

test('todo lists has many tasks', function () {

    $todolist = TodoList::factory()->hasTask(3)->create();
    dd($todolist->id);
    $this->assertInstanceOf(Task::class, $todolist->task->first());
});

test('todo list belongs to many users', function () {

    $todolist = TodoList::factory()->hasUsers(3)->create();

    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $todolist->users);
});


test('deleting todo list also deletes its tasks', function () {

    $todolist = TodoList::factory()->create();
    $todolist2 = TodoList::factory()->create();
    $task = Task::factory()->create();
    $task2 = Task::factory()->create();

    $todolist->delete();
    $task->delete();

    $this->assertDatabaseMissing('todo_lists', ['id' => $todolist->id]);
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
});
