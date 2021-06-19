<?php

namespace App\Exceptions;

use Exception;

/**
 * 身份验证异常
 *
 * Class AuthException
 *
 * @package App\Exceptions
 */
class AuthException extends Exception
{
    /**
     * AuthException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = "身份验证失败，请重新登录", $code = 100)
    {
        parent::__construct($message, $code);
    }
}
