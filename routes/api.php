<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('todo/{id?}', [TodoController::class, 'getTodoList']);
Route::post('add', [TodoController::class, 'addOrUpdateTodo']);
Route::post('delete', [TodoController::class, 'deleteTodo']);

Route::post('register', [UserController::class , 'registerUser']);
Route::post('login', [UserController::class , 'loginUser']);
Route::post('logout', [UserController::class , 'logoutUser']);

Route::post('upload', [ImageController::class , 'uploadImage']);

