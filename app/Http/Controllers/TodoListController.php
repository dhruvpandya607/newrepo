<?php

namespace App\Http\Controllers;

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

    public function update(TodoListValidateRequest $request, TodoList $todo_list)
    {
        $this->authorize('update', $todo_list);

        $todo_list->update($request->validated());

        return new TodoListResource($todo_list);
    }

    public function show(TodoList $todo_list)
    {
        $this->authorize('view', $todo_list);

        return new TodoListResource($todo_list);
    }

    public function destroy(TodoList $todo_list)
    {
        $this->authorize('delete', $todo_list);

        $todo_list->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
