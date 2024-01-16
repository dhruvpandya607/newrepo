<?php

test('users registeration with validation', function () {

    $registerUser = [
        'name' => 'dhruv',
        'email' => 'dhruv@dhruv.com',
        'password' => bcrypt('password123'),
    ];

    $this->postJson('api/register', $registerUser);

    $this->assertDatabaseHas('users', $registerUser);
});
