<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\UserListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/userList',UserListController::class);
//Route::post('/userList/edit/{id}',UserListController::class,'editUser');
Route::apiResource('/todoList',ToDoController::class);
Route::get('/userlist/details/{id}',[UserListController::class,'details']);
Route::post('edit',[ToDoController::class,'editTodo']);
