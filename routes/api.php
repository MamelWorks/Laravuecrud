<?php

use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserGroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('api')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('users.groups', UserGroupController::class);
    Route::resource('groups.users', GroupUserController::class);
});

