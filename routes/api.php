<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Label\LabelController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\TodoList\TodoListController;
use App\Http\Controllers\WebService\WebServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware(['bouncer'])->group(function () {

        // Todo-lists
        Route::get('todo-lists', [TodoListController::class, 'index'])->name('todo-lists.index');
        Route::post('todo-lists', [TodoListController::class, 'store'])->name('todo-lists.store');
        Route::get('todo-lists/{todoList:id}', [TodoListController::class, 'show'])->name('todo-lists.show');
        Route::put('todo-lists/{todoList}', [TodoListController::class, 'update'])->name('todo-lists.update');
        Route::delete('todo-lists/{todoList}', [TodoListController::class, 'destroy'])->name('todo-lists.destroy');

        // Tasks
        Route::get('todo-lists/{todoList:id}/tasks', [TaskController::class, 'index']);
        Route::post('todo-lists/{todoList:id}/tasks', [TaskController::class, 'store']);
        Route::put('todo-lists/{task}/tasks', [TaskController::class, 'update']);
        Route::delete('todo-lists/{task}/tasks', [TaskController::class, 'destroy']);

        // Label
        Route::get('todo-lists/tasks/{todoList:id}/label', [LabelController::class, 'index']);
        Route::post('todo-lists/tasks/{todoList:id}/label', [LabelController::class, 'store']);
        Route::put('todo-lists/tasks/{label}/label', [LabelController::class, 'update']);
        Route::delete('todo-lists/tasks/{label}/label', [LabelController::class, 'destroy']);

        // google-drive-api todolists services
        Route::get('webservice/connect/{name}', [WebServiceController::class, 'connect'])->name('webservice.connect');
        Route::post('webservice/callback', [WebServiceController::class, 'callback'])->name('webservice.callback');
        Route::post('webservice/{webservice}', [WebServiceController::class, 'store'])->name('webservice.store');
    });
});

// Register
Route::get('register', [RegisterController::class, 'create'])
    ->name('register');
Route::post('register', [RegisterController::class, 'store'])
    ->name('user.register');

// Login
Route::get('login', [LoginController::class, 'create'])
    ->name('login');
Route::post('login', [LoginController::class, 'store'])
    ->name('user.login');
