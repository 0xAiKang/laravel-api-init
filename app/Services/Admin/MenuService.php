<?php

namespace App\Services\Admin;

use App\Enums\System\SystemMenuType;
use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Models\System\SystemMenuModel;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

/**
 * Class MenuService
 *
 * @package App\Services\Admin
 */
class MenuService
{
    /**
     * @var SystemMenuModel
     */
    protected SystemMenuModel $model;

    /**
     * MenuService constructor.
     *
     * @param \App\Models\System\SystemMenuModel $model
     */
    public function __construct(SystemMenuModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function list()
    {
        $list = $this->model->with([
            'permission'
        ])
            ->where('type', 1)
            ->orderBy('sort')
            ->get();

        $list->transform(function ($item) {
            if ($item->permission) {
                $permissionName = $item->permission->name;
                unset($item->permission);
//                unset($item->permission_id);
                $item->permission_name = $permissionName;
            }
            return $item;
        });
        return $this->toTree($list->toArray());
    }

    /**
     * @param $array
     *
     * @return array
     */
    protected function toTree($array)
    {
        $items = array_column($array, null, 'id');

        $tree = [];
        foreach ($items as $key => $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['children'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }

    /**
     * @return array
     */
    public function index()
    {
        $admin = auth('admin')->user();
        $permissionId = auth('admin')->user()->getAllPermissions()->pluck('id')->toArray();

        $builder = $this->model->newQuery();
        $builder->where("type", SystemMenuType::MENU);
        if (! $admin->is_root) {
            $builder->whereIn('permission_id', $permissionId);
        }

        $lists = $builder->with(['permission'])->orderBy('sort', 'asc')->get();
        $lists->transform(function ($item) {
            if ($item->permission) {
                $permissionName = $item->permission->name;
                unset($item->permission);
//                unset($item->permission_id);
                $item->permission_name = $permissionName;
            }
            return $item;
        });
        if ($lists->isEmpty()) {
            return [];
        }
        return $this->toTree($lists->toArray());
    }

    /**
     * 新增
     *
     * @param $params
     *
     * @throws \App\Exceptions\InternalException
     */
    public function create($params)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::create([
                'name'       => trim($params['permission_name']),
                'guard_name' => 'admin'
            ]);
            if (!$permission->id) {
                throw new InvalidRequestException('配置权限失败');
            }

            $params['permission_id'] = $permission->id;
            $pid = $params['pid'] ?? 0;
            $this->model->fill($params)->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new InternalException($exception->getMessage(), $exception);
        }
    }

    /**
     * 編輯
     *
     * @param $params
     *
     * @return bool
     */
    public function edit($params)
    {
        return $this->model->find($params['id']);
    }

    /**
     * 更新
     *
     * @param $params
     *
     * @return bool
     */
    public function update($params)
    {
        $target = $this->model->find($params['id']);
        return $target->fill($params)->save();
    }

    /**
     * 删除
     *
     * @param $id
     *
     * @return bool
     * @throws \App\Exceptions\InternalException
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->model = $this->model->find($id);
            $this->model->delete();
            $permission =
                Permission::where(['id' => $this->model->permission_id])
                    ->delete();
            //清空緩存
            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new InternalException($exception->getMessage(), $exception);
        }
    }
}
