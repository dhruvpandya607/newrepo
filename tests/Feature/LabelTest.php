<?php

use App\Models\Label;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $user = User::find(1);
    $this->withHeaders([
        'todolist' => $user->todolists()->first()->id,
    ]);
    Sanctum::actingAs($user, ['*']);
});

test('fetching all labels', function () {

    $todolist = TodoList::find(1);

    $this->getJson("api/todo-lists/tasks/{$todolist->id}/label")->assertOk();
});

test('storing a label with validation', function () {

    $todolist = TodoList::find(1);
    $label = Label::factory()->raw();

    $this->post("api/todo-lists/tasks/{$todolist->id}/label", $label)->json('data');

    $this->assertDatabaseHas('labels', $label);
});

test('updating a label with validation', function () {

    $label = Label::factory()->create();
    $updateLabel = [
        'name' => 'second label',
        'color' => 'blue',
    ];

    $this->putJson("api/todo-lists/tasks/{$label->id}/label", $updateLabel)->json('data');

    $this->assertDatabaseHas('labels', $updateLabel);
});

test('user can delete a label of task', function () {

    $label = Label::factory()->create();

    $this->delete("api/todo-lists/tasks/{$label->id}/label");

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
