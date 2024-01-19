<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Task\TaskController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Label\LabelController;
use App\Http\Controllers\Admin\TodoList\TodoListController;
use App\Http\Controllers\Admin\WebService\WebServiceController;

Route::middleware(['auth:sanctum', 'todolists'])->group(function () {

    Route::middleware(['bouncer'])->group(function () {

        // Todo-lists
        Route::apiResource('todo-lists', TodoListController::class);

        Route::prefix('todo-lists')->group(function () {

            // Tasks
            Route::get('tasks/{todoList:id}', [TaskController::class, 'index']);
            Route::post('tasks/{todoList:id}', [TaskController::class, 'store']);
            Route::put('tasks/{task}', [TaskController::class, 'update']);
            Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

            // Label
            Route::get('tasks/{todoList:id}/label', [LabelController::class, 'index']);
            Route::post('tasks/{todoList:id}/label', [LabelController::class, 'store']);
            Route::put('tasks/{label}/label', [LabelController::class, 'update']);
            Route::delete('tasks/{label}/label', [LabelController::class, 'destroy']);

            // google-drive-api todolists services
            Route::get('webservice/connect/{name}', [WebServiceController::class, 'connect']);
            Route::post('webservice/callback/{id}', [WebServiceController::class, 'callback']);
            Route::post('webservice/{webservice:id}', [WebServiceController::class, 'store']);
        });
    });
});

// Register
Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

// Login
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
