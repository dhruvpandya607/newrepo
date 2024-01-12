<?php

use App\Models\User;

test('users login with validation', function () {

    $this->withoutExceptionHandling();
    $user = User::factory()->create(['email' => 'dhruv@dhruv.com', 'password' => bcrypt('password123')]);

    $response = $this->postJson(route('user.login'), ['email' => 'dhruv@dhruv.com', 'password' => 'password123']);

    $this->assertArrayHasKey('token', $response->json());
});
