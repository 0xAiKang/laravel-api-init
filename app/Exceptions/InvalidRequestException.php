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
    use ApiResponse;

    public function __construct($message = "", $code = 400) {
        parent::__construct($message, $code);
    }

    public function render()
    {
        return $this->failed($this->message, $this->code);
    }
}
