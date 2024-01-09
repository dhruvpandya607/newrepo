<?php

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    $this->authUser = Sanctum::actingAs(User::factory()->create(), ['*']);
    $this->withoutExceptionHandling();
});

test('fetching all labels', function () {

    $task = Task::factory()->create();
    Label::factory()->create(['task_id' => $task->id]);

    $this->getJson("api/todo-lists/tasks/label/{$task->id}")->assertOk();
});

test('storing a label with validation', function () {

    $task = Task::factory()->create();
    Label::factory()->create();

    $label = ['name' => 'first label', 'color' => 'red', 'user_id' => $this->authUser->id, 'task_id' => $task->id];

    $this->post("api/todo-lists/tasks/label/{$task->id}", $label)->json('data');

    $this->assertDatabaseHas('labels', ['name' => 'first label', 'color' => 'red', 'user_id' => $this->authUser->id]);
});

test('updating a label with validation', function () {

    $label = Label::factory()->create();

    $Label = ['name' => 'second label', 'color' => 'blue'];

    $this->patchJson("api/todo-lists/tasks/label/{$label->id}", $Label)->json('data');

    $this->assertDatabaseHas('labels', ['name' => 'second label', 'color' => 'blue']);
});

test('user can delete a label of task', function () {

    $label = Label::factory()->create();

    $this->delete("api/todo-lists/tasks/label/{$label->id}");

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
