<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Rules\MobileValidator;

/**
 * Class AdminRequest
 *
 * @package App\Http\Requests\Admin
 */
class AdminRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "admin_id" => "required|exists:admin,admin_id",
            "mobile" => [
                "required",
                new MobileValidator(),
                "unique:admin,mobile",
            ],
            "avatar" => "required|url",
            "password" => "sometimes|required|string|min:6",
        ];
    }

    /**
     * @return array
     */
    public function scene()
    {
        return [
            "index" => [],
            "create" => [
                "username" => "required|between:1,25|unique:admin,username",
                "password",
                "avatar",
                "mobile",
            ],
            "update" => [
                "admin_id",
                "username" => "required|between:1,25|unique:admin,username, {$this->admin_id}," . "admin_id",
                "password",
                "avatar",
                "mobile",
            ],
            "setDisable" => [
                "admin_id"
            ],
            "getUserRoles" => [],
            "setUserRoles" => [],
            "getUserPermissions" => [],
            "setUserPermissions" => [],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            "admin_id.required" => "管理员ID 不能为空",
            "admin_id.exists"   => "管理员ID 不存在",
            "username.required" => "管理员名称不能为空",
            'username.between'  => '管理员名称必须介于 1 - 25 个字符之间',
            'username.unique'   => '管理员名称已经存在',
            "password.required" => "管理员密码不能为空",
            "password.min"      => "管理员密码至少六个字符",
            "mobile.required"   => "管理员手机号不能为空",
            'mobile.unique'     => '管理员手机号已经存在',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            "avatar" => "头像",
        ];
    }
}
