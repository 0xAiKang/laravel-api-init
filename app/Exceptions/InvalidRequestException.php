<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;

/**
 * 用户行为异常
 *
 * Class InvalidRequestException
 *
 * @package App\Exceptions
 */
class InvalidRequestException extends Exception
{
    /**
     * InvalidRequestException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = "", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
