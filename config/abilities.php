<?php

use App\Models\Label;
use App\Models\Task;
use App\Models\TodoList;

return [
    'abilities' => [

        // Todolist
        [
            'name' => 'view todolist',
            'ability' => 'view-todolist',
            'model' => TodoList::class,
        ],
        [
            'name' => 'create todolist',
            'ability' => 'create-todolist',
            'model' => TodoList::class,
        ],
        [
            'name' => 'update todolist',
            'ability' => 'update-todolist',
            'model' => TodoList::class,
        ],
        [
            'name' => 'delete todolist',
            'ability' => 'delete-todolist',
            'model' => TodoList::class,
        ],

        // Tasks
        [
            'name' => 'create task',
            'ability' => 'create-task',
            'model' => Task::class,
        ],
        [
            'name' => 'update task',
            'ability' => 'update-task',
            'model' => Task::class,
        ],
        [
            'name' => 'delete task',
            'ability' => 'delete-task',
            'model' => Task::class,
        ],

        // Label
        [
            'name' => 'create label',
            'ability' => 'create-label',
            'model' => Label::class,
        ],
        [
            'name' => 'update label',
            'ability' => 'update-label',
            'model' => Label::class,
        ],
        [
            'name' => 'delete label',
            'ability' => 'delete-label',
            'model' => Label::class,
        ],
    ],
];
