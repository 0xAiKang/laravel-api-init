<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 另一种写法
/*Route::prefix("v1")->group(function (){
    Route::prefix("users")->group(function (){
        Route::get("/index", [\App\Http\Controllers\Api\UsersController::class, "index"]);
        Route::get("/create", [\App\Http\Controllers\Api\UsersController::class, "create"]);
        Route::get("/update", [\App\Http\Controllers\Api\UsersController::class, "update"]);
    });
});*/

Route::prefix("v1")->namespace("Api")->group(function (){
    Route::prefix("users")->group(function (){
        Route::get("/index", "UsersController@index");
        Route::post("/create", "UsersController@create");
        Route::post("/update", "UsersController@update");
    });
});