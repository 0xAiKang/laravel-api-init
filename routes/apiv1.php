<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
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

/** 注意⚠️：以下接口全部需要认证身份 */
Route::middleware('auth.api')->group(function (){
    Route::prefix("users")->group(function (){
        Route::get("/test", [UsersController::class, "test"]);
        Route::get("/index", [UsersController::class, "index"]);
        Route::post("/create", [UsersController::class, "create"]);
        Route::post("/update", [UsersController::class, "update"]);
    });
});

// 另一种写法
/*Route::namespace("Api")->middleware("auth.api")->group(function (){
    Route::prefix("users")->group(function (){
        Route::get("/index", "UsersController@index")->scene("index");
        Route::post("/create", "UsersController@create")->scene("create");
        Route::post("/update", "UsersController@update")->scene("update");
    });
});*/

