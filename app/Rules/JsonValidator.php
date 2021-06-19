<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * JSON 字符串 验证
 *
 * Class JsonValidator
 *
 * @package App\Rules
 */
class JsonValidator implements Rule
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
        return is_array(json_decode($value, true));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '请求参数必须为合法JSON 字符串';
    }
}
