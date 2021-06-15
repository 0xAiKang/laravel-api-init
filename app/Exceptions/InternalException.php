<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;

/**
 * 系统内部异常
 *
 * Class InternalException
 *
 * @package App\Exceptions
 */
class InternalException extends Exception
{
    /**
     * InternalException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = "系统内部错误", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
