<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

/**
 * Class RoleModel
 *
 * @package App\Models\System
 * @property int                                                                                  $id
 * @property string                                                                               $name
 * @property string                                                                               $guard_name
 * @property \datetime|null                                                                       $created_at
 * @property \datetime|null                                                                       $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null                                                                        $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\UserModel[]           $users
 * @property-read int|null                                                                        $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoleModel extends Role
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
