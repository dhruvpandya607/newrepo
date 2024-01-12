<?php

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $user = Sanctum::actingAs(User::find(4), ['*']);
    // dd(User::find(4)->todolists()->first()->id);
    $this->withHeaders([
        'todolist' => $user->todolists->first()->id,
    ]);

    $this->withoutExceptionHandling();
});

test('fetching all labels', function () {

    $task = Task::factory()->create();

    $this->getJson("api/todo-lists/tasks/label/{$task->id}")->assertOk();
});

test('storing a label with validation', function () {

    $task = Task::factory()->create();
    $label = Label::factory()->raw();

    $this->post("api/todo-lists/tasks/label/{$task->id}", $label)->json('data');

    $this->assertDatabaseHas('labels', $label);
});

test('updating a label with validation', function () {

    $label = Label::factory()->create();

    $updatelabel = [
        'name' => 'second label',
        'color' => 'blue',
    ];

    $this->patchJson("api/todo-lists/tasks/label/{$label->id}", $updatelabel)->json('data');

    $this->assertDatabaseHas('labels', $updatelabel);
});

test('user can delete a label of task', function () {

    $label = Label::factory()->create();

    $this->delete("api/todo-lists/tasks/label/{$label->id}");

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
