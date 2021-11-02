<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

/**
 * Class RolesRequest
 *
 * @package App\Http\Requests\Admin
 */
class RolesRequest extends BaseRequest
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
            "name" => "required",
            "id"   => "required|exists:roles,id",
        ];
    }

    /**
     * @return array
     */
    public function scene()
    {
        return [
            "index"  => [],
            "create" => [
                "name"
            ],
            "update" => [
                "id", "name"
            ],
            "delete" => [
                "id"
            ],
            "edit"  => ["id"],
            "list"  => [],
            "all"   => [],
            "setRoleHasPermissions"   => [],
            "getRoleHasPermissions"   => [],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            "id"   => "角色ID",
            "name" => "角色名",
        ];
    }
}