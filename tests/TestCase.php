<?php

namespace Tests;

use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use App\Models\WebService;
use App\Models\TodoList;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function authUser()
    {
        return Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    function createUser()
    {
        return User::factory()->create();
    }

    function createTodolist($argv)
    {
        return TodoList::factory()->create($argv);
    }

    function createLabel($argv)
    {
        return Label::factory()->create($argv);
    }

    function createTask($argv)
    {
        return Task::factory()->create($argv);
    }

    function createWebService()
    {
        return WebService::factory()->create();
    }
}
