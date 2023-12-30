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
    Route::get('todo-lists/create', [TodoListController::class, 'create'])
        ->name('todo-lists.create');

    Route::apiResource('tasks', TaskController::class)->except('show');
    Route::get('tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::apiResource('label', LabelController::class)->except('show');
    Route::get('label/create', [LabelController::class, 'create'])
        ->name('label.create');

    // drive-api todolists services routes
    Route::get('/webservice/connect/{webservice}', [WebServiceController::class, 'connect'])
        ->name('webservice.connect');

    Route::post('/webservice/callback', [WebServiceController::class, 'callback'])
        ->name('webservice.callback');

    Route::post('/webservice/{webservice}', [WebServiceController::class, 'store'])
        ->name('webservice.store');
});


// Register Login routes
Route::get('register', [RegisterController::class, 'create'])
    ->name('register');
Route::post('register', [RegisterController::class, 'store'])
    ->name('user.register');

Route::get('login', [LoginController::class, 'create'])
    ->name('login');
Route::post('login', [LoginController::class, 'store'])
    ->name('user.login');
