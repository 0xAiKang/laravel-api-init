<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

/**
 * 返回的统一消息
 * Class ApiResponse
 * @package App\Traits
 */
trait  ApiResponse
{
    /**
     * 状态码
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * 获取状态码
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * 设置状态码
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * 响应数据
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return response($data, 200, $header);
    }

    /**
     * 错误响应数据
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * 成功响应数据
     * @param array $data
     * @param string $status
     * @return mixed
     */
    public function success($data=[], $status = "success")
    {
        return $this->status($status, [
            'data' => $data,
            'message' => '获取数据成功',
        ]);
    }

    /**
     * 提示信息
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = "success")
    {

        return $this->status($status, [
            'message' => $message
        ]);
    }

    /**
     * 响应状态
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null)
    {
        if ($code) {
            $this->setStatusCode($code);
        }

        $status = [
            'status' => $status,
            'code' => $this->statusCode,
            'time' => time(),
            'data' => [],
        ];

        $data = array_merge($status, $data);
        return $this->respond($data);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);
    }

    /**
     * 404 找不到文件
     * @param string $message
     * @return mixed
     */
    public function notFound($message = 'Not Found!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND);
    }
}
