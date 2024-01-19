<?php

namespace App\Http\Controllers\Viewer\TodoList;

use App\Models\TodoList;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoListResource;

class TodoListController extends Controller
{
    public function index()
    {
        $todolists = TodoList::all();

        return TodoListResource::collection($todolists);
    }

    public function show(TodoList $todolist)
    {
        dd($todolist);
        $todoLists = TodoList::where('id', $todolist);

        return new TodoListResource($todoLists);
    }
}
