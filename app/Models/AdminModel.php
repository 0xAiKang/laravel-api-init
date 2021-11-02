<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\AdminModel
 *
 * @property int                             $admin_id
 * @property string                          $username
 * @property string                          $password
 * @property string                          $mobile
 * @property string                          $avatar
 * @property int                             $role_id
 * @property int                             $is_enable
 * @property int                             $is_root
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminModel whereUsername($value)
 * @mixin \Eloquent
 */
class AdminModel extends Authenticatable implements JWTSubject
{
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
        'avatar',
        'role_id',
        'is_enable',
        'is_root',
        'created_at',
        'updated_at'
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
}
