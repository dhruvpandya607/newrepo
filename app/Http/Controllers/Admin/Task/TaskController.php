<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskValidateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TodoList;

class TaskController extends Controller
{
    public function index(TodoList $todoList)
    {
        $tasks = $todoList->tasks;

        return TaskResource::collection($tasks);
    }

    public function store(TaskValidateRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = Task::createTask($request);

        return new TaskResource($task);
    }

    public function update(TaskValidateRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
