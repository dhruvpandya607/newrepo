<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Http\Requests\TodoListValidateRequest;
use App\Http\Resources\TodoListResource;

class TodoListController extends Controller
{
    public function index()
    {
        $todolists = auth()->user()->todolist;
        return TodoListResource::collection($todolists);
    }

    public function store(TodoListValidateRequest $request)
    {

        $todo_list = TodoList::create($request->validated());

        return new TodoListResource($todo_list);
    }

    public function update(TodoListValidateRequest $request, TodoList $todo_list)
    {
        $todo_list->update($request->validated());
        return new TodoListResource($todo_list);
    }

    public function show(TodoList $todo_list)
    {
        return new TodoListResource($todo_list);
    }

    public function destroy(TodoList $todo_list)
    {
        $todo_list->delete();
    }
}
