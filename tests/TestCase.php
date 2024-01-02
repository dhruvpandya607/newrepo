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

    function createTodolist($args = [])
    {
        return TodoList::factory()->create($args);
    }

    function createLabel($args = [])
    {
        return Label::factory()->create($args);
    }

    function createTask($args = [])
    {
        return Task::factory()->create($args);
    }

    function createWebService()
    {
        return WebService::factory()->create();
    }
}
