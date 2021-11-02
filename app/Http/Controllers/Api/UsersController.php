<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Services\Api\UserService;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers\Api
 */
class UsersController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * UsersController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware("auth.api", ['except' => ['test']]);

        $this->userService = $userService;
    }

    /**
     * @return mixed
     */
    public function test()
    {
        return $this->success("ok");
    }

    /**
     * User Index
     *
     * @return mixed
     */
    public function index()
    {
        $data = $this->userService->index();

        return $this->success([
            "list" => get_item($data),
            "page" => get_page($data),
        ]);
    }

    /**
     * Create User
     *
     * @param UserRequest $request
     *
     * @return mixed
     */
    public function create(UserRequest $request)
    {
        $param = $request->only(["name", "email", "password"]);
        $this->userService->create($param);

        return $this->success();
    }

    /**
     * Update User
     *
     * @param UserRequest $request
     *
     * @return mixed
     */
    public function update(UserRequest $request)
    {
        $param = $request->only(["name", "email", "password"]);
        $this->userService->update($request->id, $param);

        return $this->success();
    }
}
