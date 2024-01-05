<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebServiceController;
use App\Http\Controllers\Auth\RegisterController;



Route::middleware(['auth:sanctum'])->group(function () {

    // Todo-lists
    Route::get('todo-lists', [TodoListController::class, 'index'])->name('todo-lists.index');
    Route::post('todo-lists', [TodoListController::class, 'store'])->name('todo-lists.store');
    Route::get('todo-lists/{todo_list}', [TodoListController::class, 'show'])->name('todo-lists.show');
    Route::patch('todo-lists/{todo_list}', [TodoListController::class, 'update'])->name('todo-lists.update');
    Route::delete('todo-lists/{todo_list}', [TodoListController::class, 'destroy'])->name('todo-lists.destroy');

    // Tasks
    Route::get('todo-lists/tasks/{todolist}', [TaskController::class, 'index']);
    Route::post('todo-lists/tasks/{todolist}', [TaskController::class, 'store']);
    Route::patch('todo-lists/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('todo-lists/tasks/{task}', [TaskController::class, 'destroy']);

    // Label
    Route::get('todo-lists/tasks/label/{task}', [LabelController::class, 'index']);
    Route::post('todo-lists/tasks/label/{task}', [LabelController::class, 'store']);
    Route::patch('todo-lists/tasks/label/{label}', [LabelController::class, 'update']);
    Route::delete('todo-lists/tasks/label/{label}', [LabelController::class, 'destroy']);


    // google-drive-api todolists services
    Route::get('webservice/connect/{name}', [WebServiceController::class, 'connect'])->name('webservice.connect');
    Route::post('webservice/callback', [WebServiceController::class, 'callback'])->name('webservice.callback');
    Route::post('webservice/{webservice}', [WebServiceController::class, 'store'])->name('webservice.store');
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
