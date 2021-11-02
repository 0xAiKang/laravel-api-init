<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;

/**
 * 系统内部异常
 *
 * Class InternalException
 *
 * @package App\Exceptions
 */
class InternalException extends Exception
{
    private array $doReport = [
        \Exception::class,
        \ErrorException::class,
        QueryException::class,
    ];

    /**
     * InternalException constructor.
     *
     * InternalException constructor.
     *
     * @param        $message
     * @param null   $exception
     * @param string $messageForUser
     * @param int    $code
     */
    public function __construct($message, $exception = null, $messageForUser = "系统内部错误", $code = 500)
    {
        if ($exception) {
            if (in_array(get_class($exception), $this->doReport)) {
                \Log::error($messageForUser, ["exception" => $exception]);

                parent::__construct($messageForUser, $code);
            } else {
                parent::__construct($message, $code);
            }
        } else {
            parent::__construct($message, $code);
        }
    }
}
