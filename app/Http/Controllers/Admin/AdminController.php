<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @var \App\Services\Admin\AdminService
     */
    protected AdminService $service;

    /**
     * AdminController constructor.
     *
     * @param \App\Services\Admin\AdminService $service
     */
    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * 获取用户角色
     * @return mixed
     */
    public function getUserRoles(AdminRequest $request)
    {
        $id = $request->input('admin_id');
        $result = $this->service->getUserRoles($id);
        return $this->success($result);
    }

    /**
     * 设置用户角色
     * @param Request $request
     * @return mixed
     * @throws \App\Exceptions\InternalException
     */
    public function setUserRoles(AdminRequest $request)
    {
        $id = $request->input('admin_id');
        $params = $request->all();
        $result = $this->service->setUserRoles($params, $id);
        return $this->success($result);
    }

    /**
     * 获取用户权限
     * @return mixed
     */
    public function getUserPermissions(AdminRequest $request)
    {
        $id = $request->input('admin_id');
        $result = $this->service->getUserPermissions($id);
        return $this->success($result);
    }

    /**
     * 设置用户权限
     * @param Request $request
     *
     */
    public function setUserPermissions(AdminRequest $request)
    {
        $id = $request->input('admin_id');
        $params = $request->all();
        $result = $this->service->setUserPermissions($params, $id);
        return $this->success($result);
    }

    /**
     * 管理员列表
     *
     * @param \App\Http\Requests\Admin\AdminRequest $request
     *
     * @return mixed
     */
    public function index(AdminRequest $request)
    {
        $data = $this->service->index($request->all());

        return $this->success([
            "list" => get_item($data),
            "page" => get_page($data),
        ]);
    }

    /**
     * 新增管理员
     *
     * @param \App\Http\Requests\Admin\AdminRequest $request
     *
     * @return mixed
     */
    public function create(AdminRequest $request)
    {
        $params = $request->only(["username", "password", "mobile"]);
        $this->service->create($params);

        return $this->success();
    }

    /**
     * 更新管理员信息
     *
     * @param \App\Http\Requests\Admin\AdminRequest $request
     *
     * @return mixed
     */
    public function update(AdminRequest $request)
    {
        $params = $request->only(["username", "password", "mobile"]);
        $this->service->update($params, $request->admin_id);

        return $this->success();
    }

    /**
     * 设置为超级管理员
     *
     * @param \App\Http\Requests\Admin\AdminRequest $request
     *
     * @return mixed
     */
    public function setRoot(AdminRequest $request)
    {
        $this->service->setRoot($request->admin_id);

        return $this->success();
    }

    /**
     * 更新管理员账号状态
     *
     * @param AdminRequest $request
     * @return mixed
     */
    public function setDisable(AdminRequest $request)
    {
        $this->service->setDisable($request->admin_id);

        return $this->success();
    }
}