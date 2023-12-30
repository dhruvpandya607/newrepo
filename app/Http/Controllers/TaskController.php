<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskValidateRequest;
use App\Models\Task;


class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return $tasks;
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(TaskValidateRequest $request)
    {
        $task = Task::create($request->all());
        return $task;
    }

    public function update(TaskValidateRequest $request, Task $task)
    {
        $Task = Task::where('id', $task->id)->update($request->all());
        return $Task;
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
