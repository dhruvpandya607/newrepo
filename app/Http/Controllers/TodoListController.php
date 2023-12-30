<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Http\Requests\TodoListValidateRequest;


class TodoListController extends Controller
{
    public function index()
    {
        $todolists = TodoList::all();
        return $todolists;
        // return view('todolist.index', ['todolists' => $todolists]);
    }

    public function create()
    {
        return view('todolist.create');
    }

    public function store(TodoListValidateRequest $request)
    {
        $Todolist = TodoList::create($request->all());
        return $Todolist;
    }

    public function update(TodoListValidateRequest $request, TodoList $todo_list)
    {
        $todolist = TodoList::where('id', $todo_list->id)->update($request->all());
        return $todolist;
    }

    public function show(TodoList $todo_list)
    {
        return view('todolist.index', $todo_list);
    }

    public function edit(string $id)
    {
        return view('todolist.edit');
    }

    public function destroy(TodoList $todo_list)
    {
        $todo_list->delete();
    }
}
