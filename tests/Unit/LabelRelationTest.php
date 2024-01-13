<?php

use App\Models\Label;
use Illuminate\Support\Facades\Artisan;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

test('label belongs to many todolist', function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->withoutExceptionHandling();

    $label = Label::factory()->hasTodolists()->create();

    $this->assertTrue($label->todolists()->exists());
});
