<?php

use App\Models\Label;
use App\Models\Task;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test('label belongs to task', function () {

    $this->withoutExceptionHandling();

    $task = Task::factory()->make();
    $label = Label::factory()->make();

    $this->assertInstanceOf(Task::class, $label->task);
});
