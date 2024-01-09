<?php

namespace Tests;

use App\Models\Label;
use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use App\Models\WebService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authUser()
    {
        return Sanctum::actingAs(User::factory()->create(), ['*']);
    }

    public function createUser()
    {
        return User::factory()->create();
    }

    public function createTodolist($args = [])
    {
        return TodoList::factory()->create($args);
    }

    public function createLabel($args = [])
    {
        return Label::factory()->create($args);
    }

    public function createTask($args = [])
    {
        return Task::factory()->create($args);
    }

    public function createWebService()
    {
        return WebService::factory()->create();
    }
}
