<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RolesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 管理后台 Routes
|--------------------------------------------------------------------------
*/

/** @note 管理员登录 */
Route::post("auth/login", [AuthController::class, "login"]);
Route::post("auth/logout", [AuthController::class, "logout"]);

/** 注意⚠️：以下接口全部需要认证身份和检查权限 */
Route::middleware(["auth.admin", "check.permissions"])->group(function () {
    /** @note 管理员管理 */
    Route::prefix("admin")->group(function () {
        Route::get("/index", [AdminController::class, "index"])->scene("index");
        Route::post("/create", [AdminController::class, "create"])->scene("create");
        Route::post("/update", [AdminController::class, "update"])->scene("create");
        Route::post("/setDisable", [AdminController::class, "setDisable"])->scene("setDisable");

        Route::post("/getUserRoles", [AdminController::class, "getUserRoles"])->scene("getUserRoles");
        Route::post("/setUserRoles", [AdminController::class, "setUserRoles"])->scene("setUserRoles");
        Route::post("/getUserPermissions", [AdminController::class, "getUserPermissions"])->scene("getUserPermissions");
        Route::post("/setUserPermissions", [AdminController::class, "setUserPermissions"])->scene("setUserPermissions");
    });

    /** @note 菜单管理 */
    Route::prefix("menu")->group(function () {
        Route::post("/list", [MenuController::class, "list"])->scene("list");
        Route::post("/index", [MenuController::class, "index"])->scene("index");
        Route::post("/create", [MenuController::class, "create"])->scene("create");
        Route::post("/update", [MenuController::class, "update"])->scene("update");
        Route::post("/delete", [MenuController::class, "delete"])->scene("delete");
        Route::post("/edit", [MenuController::class, "edit"])->scene("edit");
    });

    /** @note 角色管理 */
    Route::prefix("roles")->group(function () {
        Route::post("/list", [RolesController::class, "list"])->scene("list");
        Route::post("/all", [RolesController::class, "all"])->scene("all");
        Route::post("/create", [RolesController::class, "create"])->scene("create");
        Route::post("/update", [RolesController::class, "update"])->scene("update");
        Route::post("/delete", [RolesController::class, "delete"])->scene("delete");
        Route::post("/edit", [RolesController::class, "edit"])->scene("edit");
        Route::post("/getRoleHasPermissions", [RolesController::class, "getRoleHasPermissions"])->scene("getRoleHasPermissions");
        Route::post("/setRoleHasPermissions", [RolesController::class, "setRoleHasPermissions"])->scene("setRoleHasPermissions");
    });
});
