<?php

namespace App\Models\System;

use App\Models\BaseModel;
use App\Traits\SoftDeletesEx;
use Spatie\Permission\Models\Permission;

/**
 * App\Models\System\SystemMenuModel
 *
 * @property int                                                             $id
 * @property int                                                             $pid           父级ID
 * @property int                                                             $type          菜单类型（1.菜单、2.按钮/权限）
 * @property string                                                          $target        打开方式：_blank、_self、_parent、_top
 * @property string                                                          $title         按钮名称
 * @property string                                                          $name          路由名称
 * @property string                                                          $icon          图标
 * @property string                                                          $path          路由
 * @property string                                                          $component     前端组件
 * @property string                                                          $redirect      默认重定向路径，有子节点的菜单才有
 * @property string                                                          $controller    控制器
 * @property string                                                          $action        方法名
 * @property string                                                          $method        请求方式
 * @property string                                                          $api           API地址
 * @property string                                                          $params        参数
 * @property int                                                             $sort          排序
 * @property int                                                             $permission_id 权限ID
 * @property int                                                             $status        状态
 * @property \Illuminate\Support\Carbon                                      $is_deleted    是否删除
 * @property \datetime|null                                                  $created_at
 * @property \datetime|null                                                  $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|SystemMenuModel[] $children
 * @property-read int|null                                                   $children_count
 * @property-read Permission|null                                            $permission
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereApi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereComponent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMenuModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemMenuModel extends BaseModel
{
    use SoftDeletesEx;

    /**
     * @var string
     */
    protected $table = 'system_menu';

    /**
     * @var string[]
     */
    protected $fillable = [
        'pid',
        'status',
        'target',
        'component',
        'redirect',
        'type',
        'icon',
        'title',
        'name',
        'controller',
        'action',
        'method',
        'api',
        'path',
        'sort',
        'params',
        'permission_id'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        "is_deleted" => "int",
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany($this, 'pid', 'id');
    }
}
