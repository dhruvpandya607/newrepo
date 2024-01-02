<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskValidateRequest;


class TaskController extends Controller
{

    public function index(TodoList $todolist)
    {
        $tasks = $todolist->task;
        return TaskResource::collection($tasks);
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(TaskValidateRequest $request, TodoList $todolist)
    {
        $task = $todolist->task()->create($request->validated());
        return new TaskResource($task);
    }

    public function update(TaskValidateRequest $request, Task $task)
    {
        $task->update($request->validated());
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }

    public function edit(string $id)
    {
        return view('task.edit');
    }
}
