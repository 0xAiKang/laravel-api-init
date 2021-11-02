<?php

namespace App\Services\Admin;

use App\Exceptions\InternalException;
use App\Models\System\RoleModel;
use Spatie\Permission\Guard;

/**
 * Class RolesService
 *
 * @package App\Services\Admin
 */
class RolesService
{
    /**
     * @var \App\Models\System\RoleModel
     */
    protected RoleModel $model;

    /**
     * RolesService constructor.
     *
     * @param \App\Models\System\RoleModel $model
     */
    public function __construct(RoleModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->model->orderByDesc("id")->paginate();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $params
     */
    public function create($params)
    {
        $params['guard_name'] = "admin";
        $this->model->fill($params)->save();
    }

    /**
     * @param $params
     */
    public function update($params)
    {
        $target = $this->model->find($params['id']);
        $target->fill($params)->save();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $target = $this->model->find($id);
        $target->delete();
    }

    /**
     * 查看角色拥有的权限
     *
     * @param $id
     *
     * @return array
     */
    public function getRoleHasPermissionsTree($id)
    {
        $role = $this->model->find($id);
        //角色拥有的权限
        return $role->permissions()->get()->pluck('id')->toArray();

//        $menu = (new SystemMenu)->select(['id', 'title', 'pid', 'status', 'permission_id'])->get();
//        $permissionIds = $menu->pluck('permission_id');
//        $menu->each(function (&$e) use ($permissions) {
//            if (in_array($e->permission_id, $permissions)) {
//                $e->checked = true;
//            } else {
//                $e->checked = false;
//            }
//        });
//        $menu = $this->toTree($menu->toArray());
//        $data = [
//            'permissionIds' => $permissionIds,
//            'menuTree' => $menu,
//            'userMenuIds' => $permissions
//        ];
//        return $data;
    }

    /**
     * 角色分配权限 撤销或者新增权限
     *
     * @param $id
     * @param $permissions
     *
     * @return mixed
     * @throws \App\Exceptions\InternalException
     */
    public function setRoleHasPermissions($id, $permissions)
    {
        try {
            return $this->model->find($id)->syncPermissions($permissions);
        } catch (\Exception $exception) {
            throw new InternalException($exception->getMessage(), $exception);
        }
    }
}
