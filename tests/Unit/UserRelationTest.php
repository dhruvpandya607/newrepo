<?php

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

use App\Models\User;

test('user belongs to many todo lists', function () {

    $user = User::factory()->hasTodolists(3)->create();

    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->todolists);
});
