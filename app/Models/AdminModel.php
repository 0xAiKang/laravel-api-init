<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\AdminModel
 *
 * @property int                                                                                  $admin_id
 * @property string                                                                               $username
 * @property string                                                                               $password
 * @property string                                                                               $mobile
 * @property string                                                                               $avatar
 * @property int                                                                                  $role_id
 * @property int                                                                                  $is_enable
 * @property int                                                                                  $is_root
 * @property \Illuminate\Support\Carbon|null                                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                                      $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null                                                                        $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[]       $roles
 * @property-read int|null                                                                        $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereIsRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereUsername($value)
 * @mixin \Eloquent
 */
class AdminModel extends Authenticatable implements JWTSubject
{
    use HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * @var string
     */
    protected $primaryKey = "admin_id";

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'mobile',
        'password',
        'role_id',
        'is_enable',
        'is_root',
        'created_at',
        'updated_at'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        "password",
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 日期序列化
     *
     * @param \DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }
}
