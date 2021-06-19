<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Rules\JsonValidator;

class UserRequest extends BaseRequest
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
            "id"       => "required|exists:users,id",
            "name"     => "required|between:2,25",
            "email"    => "required",
            "password" => "required|min:6|max:24",
            "hobby"    => [
                "required",
                new JsonValidator(),
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function scene()
    {
        return [
            "index"  => [],
            "create" => [
                "name", "email", "password", "hobby"
            ],
            "update" => [
                "id", "name", "email", "password", "hobby"
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            "id"       => "用户ID",
            "name"     => "用户名称",
            "email"    => "用户邮箱",
            "password" => "用户密码",
            "hobby"    => "用户爱好",
        ];
    }
}
