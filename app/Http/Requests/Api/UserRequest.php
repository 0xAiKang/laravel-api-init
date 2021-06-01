<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

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
        switch ($this->route()->getActionMethod()) {
            case "create":
                return [
                    "name" => "required|between:2,25",
                    "email" => "required",
                    "password" => "required|min:6|max:24",
                ];
            case "update":
                return [
                    "id" => "required|exists:users,id",
                ];
        }
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            "name" => "用户名称",
            "email" => "用户邮箱",
            "password" => "用户密码",
            "id" => "用户ID",
        ];
    }
}
