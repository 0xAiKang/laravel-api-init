<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var \App\Services\Api\AuthService
     */
    protected AuthService $service;

    /**
     * AuthController constructor.
     */
    public function __construct(AuthService $service)
    {
        $this->middleware("auth.admin", ['except' => ['login']]);

        $this->service = $service;
    }

    /**
     * 管理员登录
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function login(Request $request)
    {
        $data = $this->service->login($request);

        return $this->success($data);
    }

    /**
     * 退出登录
     *
     * @return mixed
     */
    public function logout()
    {
        auth("admin")->logout();

        return $this->success();
    }
}
