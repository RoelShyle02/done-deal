<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

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


Route::post('signup', [UserController::class, 'signup']);
Route::post('login', [UserController::class, 'login']);


Route::middleware('auth:sanctum',)->group(function () {

    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/session', function () {
        return auth()->user();
    });
    Route::get('/planners', [TaskController::class, 'getPlanners']);
    Route::get('/tasks', [TaskController::class, 'getTasks']);
    Route::post('/create-planner', [TaskController::class, 'createPlanner']);
});
