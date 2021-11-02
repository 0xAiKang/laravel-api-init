<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 手机号验证
 *
 * Class MobileValidator
 *
 * @package App\Rules
 */
class MobileValidator implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // 除了11、12 打头的手机号，其余都放行
        return preg_match('/^(13[0-9]|14[0-9]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '请输入正确的手机号';
    }
}
