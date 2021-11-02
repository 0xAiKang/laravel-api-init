<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 『钱』验证，必须为正实数，且只能有 1～2 位小数
 *
 * Class AmountValidator
 *
 * @package App\Rules
 */
class AmountValidator implements Rule
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
        return preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "金额不能为负数，且最多只能有两位小数";
    }
}
