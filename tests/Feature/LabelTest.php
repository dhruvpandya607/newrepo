<?php

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->authUser = Sanctum::actingAs(User::factory()->create(), ['*']);

    $this->withoutExceptionHandling();
});

test('fetching all labels', function () {

    $task = Task::factory()->create();
    Label::factory()->create();

    $this->getJson("api/todo-lists/tasks/label/{$task->id}")->assertOk();
});

test('storing a label with validation', function () {

    $task = Task::factory()->create();
    $label = Label::factory()->create([
        'name' => 'first label',
        'color' => 'red',
        'user_id' => $this->authUser->id,
        'task_id' => $task->id,
    ])->toArray();

    $this->post("api/todo-lists/tasks/label/{$task->id}", $label)->json('data');

    $this->assertDatabaseHas('labels', $label);
});

test('updating a label with validation', function () {

    $label = Label::factory()->create(['user_id' => $this->authUser->id]);

    $updatelabel = [
        'name' => 'second label',
        'color' => 'blue',
    ];

    $this->patchJson("api/todo-lists/tasks/label/{$label->id}", $updatelabel)->json('data');

    $this->assertDatabaseHas('labels', $updatelabel);
});

test('user can delete a label of task', function () {

    $label = Label::factory()->create(['user_id' => $this->authUser->id]);

    $this->delete("api/todo-lists/tasks/label/{$label->id}");

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
