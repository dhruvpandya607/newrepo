<?php

namespace App\Http\Controllers\Admin\TodoList;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoListValidateRequest;
use App\Http\Resources\TodoListResource;
use App\Models\TodoList;

class TodoListController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', TodoList::class);

        $todolists = TodoList::all();

        return TodoListResource::collection($todolists);
    }

    public function store(TodoListValidateRequest $request)
    {
        $this->authorize('create', TodoList::class);

        $todo_list = TodoList::createTodolist($request);

        return new TodoListResource($todo_list);
    }

    public function update(TodoListValidateRequest $request, TodoList $todoList)
    {
        $this->authorize('update', $todoList);

        $todoList->update($request->validated());

        return new TodoListResource($todoList);
    }

    public function show(TodoList $todoList)
    {
        $this->authorize('view', $todoList);

        return new TodoListResource($todoList);
    }

    public function destroy(TodoList $todoList)
    {
        $this->authorize('delete', $todoList);

        $todoList->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
