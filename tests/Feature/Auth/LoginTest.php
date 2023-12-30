<?php

use App\Models\User;

test('users login with validation', function () {

    $this->withoutExceptionHandling();
    $user = User::factory()->create();

    $response = $this->postJson(route('user.login'), ['email' => $user->email, 'password' => 'password']);

    $this->assertArrayHasKey('token', $response->json());
});
