<?php


test('users registeration with validation', function () {

    $this->withoutExceptionHandling();

    $this->postJson(route('user.register'), ['name' => 'dhruv', 'email' => 'dhruv@dhruv.com', 'password' => 'password']);

    $this->assertDatabaseHas('users', ['name' => 'dhruv']);
});
