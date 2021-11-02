<?php

namespace App\Services\Admin;

use App\Exceptions\InvalidRequestException;

/**
 * Class AuthService
 *
 * @package App\Services\Api
 */
class AuthService
{
    /**
     * 登录
     *
     * @param $request
     *
     * @return array
     * @throws \App\Exceptions\InvalidRequestException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login($request)
    {
        $rules = [
            "username" => "required",
            "password" => "required",
        ];

        $validator = validator($request->all(), $rules);

        if ($validator->fails()) {
            throw new InvalidRequestException("用户名或密码不能为空");
        }

        if (!$token = auth("admin")->attempt($validator->validated())) {
            throw new InvalidRequestException("用户名或密码错误");
        }

        return [
            "token"      => $token,
            'token_type' => 'Bearer',
        ];
    }
}
