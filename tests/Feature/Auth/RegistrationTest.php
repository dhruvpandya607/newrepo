<?php

test('users registeration with validation', function () {

    $this->withoutExceptionHandling();

    $registerUser = ['name' => 'dhruv', 'email' => 'dhruv@dhruv.com', 'password' => bcrypt('password123')];

    $this->postJson(route('user.register'), $registerUser);

    $this->assertDatabaseHas('users', $registerUser);
});
