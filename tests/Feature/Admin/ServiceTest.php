<?php

use App\Models\Task;
use App\Models\User;
use App\Models\WebService;
use Google\Client;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

beforeEach(function () {

    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

    $this->user = User::find(1);
    $this->withHeaders([
        'todolist' => $this->user->todolists()->first()->id,
    ]);
    Sanctum::actingAs($this->user, ['*']);
});

test('user connect to a service and redirect', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('setScopes')->once();
        $mock->shouldReceive('createAuthUrl')
            ->andReturn('http://localhost');
    });

    $response = $this->getJson('api/todo-lists/webservice/connect/todolists')->assertok();

    $this->assertEquals($response['uri'], 'http://localhost');
});

test('storing access token with service callback', function () {

    $this->mock(Client::class, function (MockInterface $mock) {
        $mock->shouldReceive('fetchAccessTokenWithAuthCode')
            ->andReturn(['access_token' => 'fake-token']);
    });

    $this->postJson("api/todo-lists/webservice/callback/{$this->user->id}", ['code' => 'dummyCode'])->assertCreated();
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

    $this->postJson("api/todo-lists/webservice/{$webservice->id}")->assertCreated();
});
