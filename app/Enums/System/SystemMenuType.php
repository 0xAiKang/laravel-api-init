<?php

namespace App\Enums\System;

use BenSampo\Enum\Enum;

/**
 * Class SystemMenuType
 *
 * @package App\Enums\System
 */
class SystemMenuType extends Enum
{
    const MENU = 1;
    const BUTTON = 2;

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::MENU:
                return "菜单";

            case self::BUTTON:
                return "按钮/权限";

            default:
                return self::getKey($value);
        }
    }
}