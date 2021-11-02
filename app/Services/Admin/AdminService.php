<?php

namespace App\Services\Admin;

use App\Enums\Admin\AdminStatus;
use App\Exceptions\InternalException;
use App\Models\AdminModel;
use App\Models\System\RoleModel;
use Spatie\Permission\Models\Permission;

/**
 * Class AdminService
 *
 * @package App\Services\Admin
 */
class AdminService
{

    /**
     * @var AdminModel
     */
    protected AdminModel $model;

    /**
     * AdminService constructor.
     *
     * @param \App\Models\AdminModel $model
     */
    public function __construct(AdminModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(array $params)
    {
        $builder = $this->model->newQuery();

        // 关键字查询
        if ($keyword = $params['keyword'] ?? false) {
            $like = '%' . $keyword . '%';
            $builder->where(function ($query) use ($like) {
                $query->where("username", "like", $like)
                    ->orWhere("mobile", "like", $like);
            });
        }

        return $builder
            ->select([
                "admin_id",
                "username",
                "mobile",
                "avatar",
                "is_enable",
                "is_root",
                "created_at",
            ])
            ->orderBy("admin_id", "desc")
            ->paginate();
    }

    /**
     * 新增管理员
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $data['is_enable'] = true;
        $this->model->create($data);
    }

    /**
     * 更新管理员信息
     *
     * @param array $data
     * @param       $admin_id
     */
    public function update(array $data, $admin_id)
    {
        if (is_null($data["password"])) {
            unset($data['password']);
        }

        $admin = $this->model->find($admin_id);
        $admin->update($data);
    }

    /**
     * 更新管理员账号状态
     *
     * @param $admin_id
     */
    public function setDisable($admin_id)
    {
        $admin = $this->model->find($admin_id);
        $admin->is_enable ^= 1;

        $admin->save();
    }

    /**
     * 查看用户拥有的角色
     *
     * @param $id
     *
     * @return array
     */
    public function getUserRoles($id)
    {
        $model = $this->model->find($id);
        $roles = $model->roles;
        $data = [];
        $roles->each(function ($per) use (&$data) {
//            $data[] = strval($per->id);
            $data[] = $per;
        });
        return $data;
    }

    /**
     * 设置用户角色
     */
    public function setUserRoles($params, $id)
    {
        $model = $this->model->find($id);
//        $roles = $params['roles'] ?? [];

        $roles = explode(',', $params['roles']);
        $roleNames = RoleModel::whereIn('id', $roles)->pluck('name')->toArray();
        try {

            $model->syncRoles($roleNames);
            return true;
        } catch (InternalException $exception) {
            throw new InternalException();
        }
    }

    /**
     * 用户拥有的权限
     */
    public function getUserPermissions($id)
    {
        $model = $this->model->find($id);
        $roles = $model->permissions;
        $data = [];
        $roles->each(function ($per) use (&$data) {
            $data[] = $per;
        });
        return $data;
    }

    /**
     * 用户分配权限
     */
    public function setUserPermissions($params, $id)
    {
        $params['permissions'] = explode(',', $params['permissions']);
        $permissions = isset($params['permissions']) ?
            Permission::whereIn('id', $params['permissions'])->get() :
            [];

        try {
            $user = $this->model->find($id)->syncPermissions($permissions);
            return true;
        } catch (InternalException $exception) {
            throw new InternalException();
        }
    }
}
