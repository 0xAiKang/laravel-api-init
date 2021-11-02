<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesRequest;
use App\Services\Admin\RolesService;

/**
 * Class RolesController
 *
 * @package App\Http\Controllers\Admin
 */
class RolesController extends Controller
{
    /**
     * @var \App\Services\Admin\RolesService
     */
    protected RolesService $service;

    /**
     * RolesController constructor.
     *
     * @param \App\Services\Admin\RolesService $service
     */
    public function __construct(RolesService $service)
    {
        $this->service = $service;
    }

    /**
     * 列表
     *
     * @param RolesRequest $request
     *
     * @return mixed
     */
    public function list(RolesRequest $request)
    {
        $data = $this->service->list();

        return $this->success([
            "list" => get_item($data),
            "page" => get_page($data),
        ]);
    }

    /**
     * 不分页列表
     *
     * @return mixed
     */
    public function all()
    {
        $data = $this->service->all();

        return $this->success($data);
    }

    /**
     * 添加
     *
     * @param RolesRequest $request
     *
     * @return mixed
     */
    public function create(RolesRequest $request)
    {
        $this->service->create($request->all());
        return $this->success();
    }

    /**
     * 修改
     *
     * @param RolesRequest $request
     *
     * @return mixed
     */
    public function update(RolesRequest $request)
    {
        $this->service->update($request->all());
        return $this->success();
    }

    /**
     * 詳情
     *
     * @param RolesRequest $request
     *
     * @return mixed
     */
    public function edit(RolesRequest $request)
    {
        $result = $this->service->edit($request->all());
        return $this->success($result);
    }

    /**
     * 刪除
     *
     * @param RolesRequest $request
     *
     * @return mixed
     */
    public function delete(RolesRequest $request)
    {
        $this->service->delete($request->input('id'));
        return $this->success();
    }

    /**
     * 获取角色权限
     *
     * @param RolesRequest $request
     *
     * @return mixed
     */
    public function getRoleHasPermissions(RolesRequest $request)
    {
        $result = $this->service->getRoleHasPermissionsTree($request->input('id'));
        return $this->success($result);
    }

    /**
     * 设置角色权限
     *
     * @param RolesRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\InternalException
     */
    public function setRoleHasPermissions(RolesRequest $request)
    {
        $id = $request->input('id');
        $permissions = $request->input('permissions');
        $permissions = json_decode($permissions);
        $result = $this->service->setRoleHasPermissions($id, $permissions);
        return $this->success($result);
    }
}
