<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

/**
 * Class MenuRequest
 *
 * @package App\Http\Requests\Admin
 */
class MenuRequest extends BaseRequest
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
            "id"              => "required|exists:system_menu,id",
            "pid"             => "sometimes|required",
            "type"            => "required",
            "title"           => "required",
            "icon"            => "required",
            "component"       => "required",
            "permission_name" => "required",
        ];
    }

    /**
     * @return array
     */
    public function scene()
    {
        return [
            "index"  => [],
            "list"   => [],
            "create" => [
                "pid",
                "type",
                "title",
                "icon",
                "component",
                "permission_name"
            ],
            "update" => [
                "id",
                "pid",
                "type",
                "title",
                "icon",
                "component"
            ],
            "delete" => [
                "id",
            ],
            "edit"  => [
                "id"
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            "pid"             => "父级id",
            "id"              => "ID",
            "type"            => "菜单类型",
            "title"           => "菜单名称",
            "icon"            => "icon",
            "component"       => "前端uri或者组件名",
            "permission_name" => "权限",
        ];
    }
}
