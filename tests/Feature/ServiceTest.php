<?php

use Google\Client;
use App\Models\Task;
use App\Models\User;
use App\Models\WebService;
use Mockery\MockInterface;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->user = Sanctum::actingAs(User::find(4), ['*']);

    $this->withoutExceptionHandling();
});

test('user connect to a service and redirect', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('setScopes')->once();
        $mock->shouldReceive('createAuthUrl')->andReturn('http://localhost');
    });

    $response = $this->getJson(route('webservice.connect', 'todolists'))->assertok();

    $this->assertEquals($response['uri'], 'http://localhost');
});

test('storing access token with service callback', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('fetchAccessTokenWithAuthCode')->andReturn(['access_token' => 'fake-token']);
    });

    $this->postJson(route('webservice.callback', $this->user->id), ['code' => 'dummyCode'])->assertCreated();
});

test('storing a weekly data into google drive', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('setAccessToken')->once();
        $mock->shouldReceive('getLogger->info')->once();
        $mock->shouldReceive('shouldDefer')->once();
        $mock->shouldReceive('execute')->once();
    });

    Task::factory()->create(['created_at' => now()->subDays(2)]);
    Task::factory()->create(['created_at' => now()->subDays(9)]);
    $webservice = WebService::factory()->create();

    $this->postJson(route('webservice.store', $webservice->id))->assertCreated();
});
