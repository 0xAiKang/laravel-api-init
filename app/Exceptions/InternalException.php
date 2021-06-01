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
    use ApiResponse;

    protected $msgForUser;

    public function __construct($message = "", string $msgForUser = '系统内部错误', $code = 500)
    {
        parent::__construct($message, $code);
        $this->msgForUser = $msgForUser;
    }

    public function render()
    {
        return $this->failed($this->msgForUser);
    }
}
