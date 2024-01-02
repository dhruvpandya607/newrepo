<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebServiceController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/', function () {
    return view('layout');
});



Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResource('todo-lists', TodoListController::class);

    // Route::apiResource('tasks', TaskController::class)->except('show')->shallow();
    Route::get('tasks/{todolist}', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks/{todolist}', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::apiResource('label', LabelController::class)->except('show');
});


// google drive-api todolists services routes
Route::get('/webservice/connect/{webservice}', [WebServiceController::class, 'connect'])
    ->name('webservice.connect');

Route::post('/webservice/callback', [WebServiceController::class, 'callback'])
    ->name('webservice.callback');

Route::post('/webservice/{webservice}', [WebServiceController::class, 'store'])
    ->name('webservice.store');


// Register Login routes
Route::get('register', [RegisterController::class, 'create'])
    ->name('register');
Route::post('register', [RegisterController::class, 'store'])
    ->name('user.register');

Route::get('login', [LoginController::class, 'create'])
    ->name('login');
Route::post('login', [LoginController::class, 'store'])
    ->name('user.login');
