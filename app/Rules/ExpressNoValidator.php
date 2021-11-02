<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 物流单号验证
 * 规则：数字、字母（不区分大小写）、下划线、短横线
 *
 * Class ExpressNoValidator
 *
 * @package App\Rules
 */
class ExpressNoValidator implements Rule
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
        return preg_match('/^[\u4E00-\u9FA5A-Za-z0-9_-]+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '请输入正确的物流单号';
    }
}
