<?php

use App\Models\User;
use App\Models\Label;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $user = User::find(1);
    $this->withHeaders([
        'todolist' => $user->todolists()->first()->id,
    ]);
    Sanctum::actingAs($user, ['*']);
});

test('fetching all labels', function () {

    $todolist = TodoList::factory()->create();

    $this->getJson("api/todo-lists/tasks/label/{$todolist->id}")->assertOk();
});

test('storing a label with validation', function () {

    $todolist = TodoList::factory()->create();
    $label = Label::factory()->create()->toArray();

    $this->post("api/todo-lists/tasks/label/{$todolist->id}", $label)->json('data');

    $this->assertDatabaseHas('labels', $label);
});

test('updating a label with validation', function () {

    $label = Label::factory()->create();
    $updatelabel = Label::factory()->create([
        'name' => 'second label',
        'color' => 'blue'
    ])->toArray();

    $this->patchJson("api/todo-lists/tasks/label/{$label->id}", $updatelabel)->json('data');

    $this->assertDatabaseHas('labels', $updatelabel);
});

test('user can delete a label of task', function () {

    $label = Label::factory()->create();

    $this->delete("api/todo-lists/tasks/label/{$label->id}");

    $this->assertDatabaseMissing('labels', ['id' => $label->id]);
});
