<?php

use Google\Client;
use Mockery\MockInterface;

test('user connect to a service and redirect', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('setScopes')->once();
        $mock->shouldReceive('createAuthUrl')->andReturn('http://localhost');
    });

    $this->withoutExceptionHandling();
    $this->authUser();

    $response = $this->getJson(route('webservice.connect', 'todolists'))->assertok();

    $this->assertEquals($response['uri'], 'http://localhost');
});

test('storing access token with service callback', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('fetchAccessTokenWithAuthCode')->andReturn(['access_token' => 'fake-token']);
    });

    $this->withoutExceptionHandling();
    $authuser = $this->authUser();

    $this->postJson(route('webservice.callback', $authuser->id), ['code' => 'dummyCode'])->assertCreated();

    $this->assertDatabaseHas('web_services', [
        'user_id' => auth()->id()
    ]);
});

test('storing a weekly data into google drive', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('setAccessToken')->once();
        $mock->shouldReceive('getLogger->info')->once();
        $mock->shouldReceive('shouldDefer')->once();
        $mock->shouldReceive('execute')->once();
    });

    $this->withoutExceptionHandling();
    $this->authUser();
    $this->createTask(['created_at' => now()->subDays(2)]);
    $this->createTask(['created_at' => now()->subDays(3)]);
    $this->createTask(['created_at' => now()->subDays(4)]);
    $this->createTask(['created_at' => now()->subDays(9)]);
    $webservice = $this->createWebService();

    $this->postJson(route('webservice.store', $webservice->id))->assertCreated();
});
